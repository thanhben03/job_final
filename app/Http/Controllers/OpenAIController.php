<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Product;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function getResponse(Request $request)
    {
        // Prompt của người dùng từ request
        $prompt = $request->input('prompt');


        // Định nghĩa function 
        $functions = [
            [
                'name' => 'get_job_details',
                'description' => 'Fetches jobs details from the database',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'job_id' => [
                            'type' => 'integer',
                            'description' => 'The ID of the jobs'
                        ]
                    ],
                    'required' => ['job_id']
                ]
            ],
            [
                'name' => 'search_jobs_by_title',
                'description' => 'Search for jobs with titles that match skills if the user only provides skills and does not specify a salary.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'skills' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'string',
                            ],
                            'description' => 'List of skills the user possesses',
                        ],
                    ],
                    'required' => ['skills']
                ]
            ],
            [
                'name' => 'search_jobs',
                'description' => 'Search for jobs based on specific criteria including salary and skills. This function is called only if the user provides both criteria: salary and skills.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'salary' => [
                            'type' => 'number',
                            'description' => 'Minimum salary for job listings',
                        ],
                        'skills' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'string',
                            ],
                            'description' => 'List of skills to match with job titles',
                        ],
                        'limit' => [
                            'type' => 'integer',
                            'description' => 'Maximum number of job listings to return',
                        ],
                    ],
                    'required' => ['salary', 'skills']
                ]
            ]

        ];
        $functions2 = [
            [
                'name' => 'search_job',
                'description' => 'Fetches jobs details from the database based on skills, location and salary',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'skills' => [
                            'type' => 'string',
                            'description' => 'The skills required for the job'
                        ],
                        'location' => [
                            'type' => 'string',
                            'description' => 'The location of the job'
                        ],
                        'salary' => [
                            'type' => 'integer',
                            'description' => 'The minimum salary required for the job'
                        ]
                    ]
                    // 'required' => ['skills', 'location', 'salary']
                ]
            ]
        ];

        // Gọi OpenAI API
        $response = $this->openAIService->callFunction($prompt, $functions2);

        // Kiểm tra nếu OpenAI yêu cầu gọi function
        if (isset($response['choices'][0]['message']['function_call'])) {
            $functionName = $response['choices'][0]['message']['function_call']['name'];
            $arguments = json_decode($response['choices'][0]['message']['function_call']['arguments'], true);

            // Gọi hàm get_product_details
            if ($functionName === 'get_job_details') {
                $productId = $arguments['job_id'];
                //                $product = $this->getJobDetails($productId);
                //                dd($product);
                return response()->json([
                    'role' => 'assistant',
                    'content' => $this->getProductDetails($productId)
                ]);
            }

            // Gọi hàm search_jobs_by_title
            if ($functionName === 'search_jobs_by_title') {
                $skills = $arguments['skills'];
                $jobs = $this->searchJobsByTitle($skills);
                $html = $this->getListJobHtml($jobs);
                return response()->json([
                    'role' => 'assistant',
                    'content' => $html
                ]);
            }

            // Gọi hàm search_jobs_by_title
            if ($functionName === 'search_job') {
                $skills = $arguments['skills'] ?? null;
                $location = $arguments['location'] ?? null;
                $salary = $arguments['salary'] ?? null;

                $jobs = $this->searchJob($skills, $location, $salary);
                $html = $this->getListJobHtml($jobs);
                return response()->json([
                    'role' => 'assistant',
                    'content' => $html
                ]);
            }

            if ($functionName === 'search_jobs') {
                $salary = $arguments['salary'];
                $skills = $arguments['skills'];
                $limit = $arguments['limit'] ?? 10;

                $jobs = $this->searchJobs($salary, $skills, $limit);
                $html = $this->getListJobHtml($jobs);
                return response()->json([
                    'role' => 'assistant',
                    'content' => $html
                ]);
            }
        }
        $content = $response['choices'][0]['message'];
        $html = '
                <div class="d-flex flex-row justify-content-start mb-4">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">
                                        ' . $content['content'] . '
                                    </p>
                                </div>
                            </div>
                ';
        return response()->json([
            'role' => $content['role'],
            'content' => $html
        ]);
    }

    // hàm search tổng hợp
    public function searchJob ($skills = null, $location = null, $salary = null) {
        $careers = Career::query()
            ->when($salary, function ($query) use ($salary) {
                $query->where('max_salary', '>=', $salary);
            })
            ->when($skills, function ($query) use ($skills) {
                // $skillsString = implode(',', $skills);
                $query->join('career_details', 'careers.id', '=', 'career_details.career_id')
                ->whereRaw(
                    "MATCH(careers.title) AGAINST(? IN BOOLEAN MODE)
                    OR MATCH(career_details.description) AGAINST(? IN BOOLEAN MODE)
                    OR MATCH(career_details.requirement) AGAINST(? IN BOOLEAN MODE)
                    ",
                    [$skills, $skills, $skills]
                );
            })
            ->when($location, function ($query) use ($location) {
                $query->whereRaw(
                    "MATCH(careers.address) AGAINST(? IN BOOLEAN MODE)",
                    [$location]);
            })
            ->orderBy('careers.created_at', 'desc')
            ->take(10)
            ->get();


        return $careers;
    }

    // Hàm lấy thông tin sản phẩm
    public function getJobDetails($productId)
    {
        $product = Career::find($productId); // Giả sử Product là model sản phẩm của bạn

        return $product ?? response()->json(['error' => 'Product not found'], 404);
    }

    // Hàm tìm công việc dựa theo tiêu đề và kỹ năng bằng Full-Text Search
    public function searchJobsByTitle($skills)
    {
        // Sử dụng Full-Text Search trên cột 'title' của bảng Career
        $skillsString = implode(' ', $skills);

        $jobs = Career::query()
            ->join('career_details', 'careers.id', '=', 'career_details.career_id')
            ->whereRaw(
                "MATCH(careers.title) AGAINST(? IN BOOLEAN MODE)
                OR MATCH(career_details.description) AGAINST(? IN BOOLEAN MODE)
                OR MATCH(career_details.requirement) AGAINST(? IN BOOLEAN MODE)
                ",
                [$skillsString, $skillsString, $skillsString]
            )
            ->get();

        return $jobs;
    }

    public function searchJobs($salary, $skills, $limit)
    {
        // Kết hợp các kỹ năng thành một chuỗi
        $skillsString = implode(' ', $skills);

        // Truy vấn tìm kiếm
        $jobs = Career::where('max_salary', '>', $salary) // Điều kiện cho mức lương
            ->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$skillsString])
            ->limit($limit) // Giới hạn số lượng kết quả trả về
            ->get();

        return $jobs;
    }

    public function getListJobHtml($items)
    {
        $item = $items->map(function ($item) {
            $category = $item->category;
            $slug = "/jobs/$category->slug/$item->slug";
            return "<li><a href='$slug'>$item->title</a></li>";
        })->toArray();

        $item = implode($item);

        $html = '
                <div class="d-flex flex-row justify-content-start mb-4 chat-start">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">
                                        <p>Một số công việc gợi ý cho bạn</p>
                                        <ul class="mx-3">
                                            ' . $item . '
                                        </ul>
                                    </p>
                                </div>
                            </div>
                ';

        return $html;
    }
}
