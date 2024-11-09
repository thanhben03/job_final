<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Category;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

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
        $categories = $this->getCategory();
        $functions2 = [
            [
                'name' => 'search_job',
                'description' => "Search job listings based on user input. Users can select one or more of the following parameters: skills, location, salary, or category. Each field is optional and the system will return relevant job listings based on the criteria provided.",
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'skills' => [
                            'type' => 'string',
                            'description' => 'Specify the skills required for the job (e.g., programming, management).'
                        ],
                        'location' => [
                            'type' => 'string',
                            'description' => 'Specify the location where the job is based (e.g., New York, remote).'
                        ],
                        'salary' => [
                            'type' => 'integer',
                            'description' => 'Specify the minimum salary required for the job (e.g., 50000 for $50,000/year).'
                        ],
                        'categories' => [
                            'type' => 'array',
                            'description' => 'Specify one or more categories or fields for the job (e.g., IT, healthcare, finance).',
                            'items' => [
                                'type' => 'string',
                                'enum' => $categories
                            ]
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

            // Gọi hàm search_jobs_by_title
            if ($functionName === 'search_job') {
                $skills = $arguments['skills'] ?? null;
                $location = $arguments['location'] ?? null;
                $salary = $arguments['salary'] ?? null;
                $categories = $arguments['categories'] ?? null;
                $jobs = $this->searchJob($skills, $location, $salary, $categories);

//                $html = $this->getListJobHtml($jobs);
                return response()->json([
                    'role' => 'assistant',
                    'content' => $jobs
                ]);
            }
        }
        $content = $response['choices'][0]['message'];

        return response()->json([
            'role' => $content['role'],
            'content' => $content['content']
        ]);
    }

    // hàm search tổng hợp
    public function searchJob($skills = null, $location = null, $salary = null, $categories)
    {
        $careers = Career::query()
            ->when($salary, function ($query) use ($salary) {
                $query->where('min_salary', '>=', $salary);
            })
            ->when($categories, function ($query) use ($categories) {
                $query->whereHas('category', function ($query) use ($categories) {
                    $query->whereIn('name', $categories);
                });
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
                    [$location]
                );
            })
            ->orderBy('careers.updated_at', 'desc')
            ->take(10)
            ->get();

        return $careers;
    }


    public function getCategory()
    {
        return Category::all()->pluck('name')->toArray();
    }

}
