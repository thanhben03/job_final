<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Category;
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
        $categories = $this->getCategory();
        $functions2 = [
            [
                'name' => 'search_job',
                'description' => "Tìm việc làm dựa trên kỹ năng, vị trí,mức lương hoặc các tiêu chí khác. Chỉ trả về các kết quả theo tiêu chí của người dùng gửi lên",
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'skills' => [
                            'type' => 'string',
                            'description' => 'The skills required for the job (e.g., programming, management). You can provide multiple skills separated by commas.'
                        ],
                        'location' => [
                            'type' => 'string',
                            'description' => 'vị trí người dùng đưa ra ví dụ Hồ Chí Minh, Hà Nội, Cần Thơ v.v...'
                        ],
                        'salary' => [
                            'type' => 'integer',
                            'description' => 'Mức lương đưa ra ex: trên 10 triệu, 10 triệu, dưới 10 triệu'
                        ],
                        'categories' => [
                            'type' => 'array',
                            'description' => 'Các ngành nghề người dùng đưa ra ví dụ: công nghệ thông tin, xây dựng, marketing',
                            'items' => [
                                'type' => 'string',
                                'enum' => $categories
                            ]
                        ]
                    ],
                    'additionalProperties' => false // Ensure no extra fields are allowed
                ]
            ]
        ];



        // Gọi OpenAI API
        $response = $this->openAIService->callFunction($prompt, $functions2);

        // Kiểm tra nếu OpenAI yêu cầu gọi function
        if (isset($response['choices'][0]['message']['function_call'])) {
            $functionName = $response['choices'][0]['message']['function_call']['name'];
            $arguments = json_decode($response['choices'][0]['message']['function_call']['arguments'], true);


            // Gọi hàm search_jobs_by_title
            if ($functionName === 'search_job') {
                $skills = $arguments['skills'] ?? null;
                $location = $arguments['location'] ?? null;
                $salary = $arguments['salary'] ?? null;
                $categories = $arguments['categories'] ?? null;
                $jobs = $this->searchJob($skills, $location, $salary, $categories);
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
    public function searchJob($skills = null, $location = null, $salary = null, $categories = null)
    {

        $careers = Career::query()
            ->when($salary, function ($query) use ($salary) {
                $query->where('min_salary', '>=', $salary);
                Log::info('salary: ' . $salary);
            })
            ->when($categories, function ($query) use ($categories) {
                $query->whereHas('category', function ($query) use ($categories) {
                    $query->whereIn('name', $categories);
                });
                Log::info($categories);
            })
            ->when($skills, function ($query) use ($skills) {
                // $skillsString = implode(',', $skills);
                $query->leftJoin('career_details', 'careers.id', '=', 'career_details.career_id')
                    ->whereRaw(
                        "
                        (
                        MATCH(careers.title) AGAINST(? IN BOOLEAN MODE)
                        OR MATCH(career_details.description) AGAINST(? IN BOOLEAN MODE)
                        OR MATCH(career_details.requirement) AGAINST(? IN BOOLEAN MODE)
                        )

                        ",
                        [$skills, $skills, $skills]
                    );
                Log::info('skills: ' . $skills);
            })
            ->when($location, function ($query) use ($location) {
                $query->whereRaw(
                    "MATCH(careers.address) AGAINST(? IN NATURAL LANGUAGE MODE)",
                    [$location]
                );
                Log::info('location: ' . $location);
            })
            ->orderBy('careers.updated_at', 'desc')
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
            $slug = "/jobs/$item->slug";
            return "<li><a href='$slug'>$item->title</a></li>";
        })->toArray();
        $html = '';
        if (count($item) > 0) {
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
        } else {
            $html = '
                <div class="d-flex flex-row justify-content-start mb-4 chat-start">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">
                                        Không có công việc nào, hãy quay lại sau nhé !
                                    </p>
                                </div>
                            </div>
                ';
        }

        return $html;
    }

    public function getCategory()
    {
        return Category::all()->pluck('name')->toArray();
    }

}
