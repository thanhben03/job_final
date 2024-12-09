<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\Category;
use App\Models\CurriculumVitae;
use App\Models\Product;
use App\Services\OpenAIService;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
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
                            'description' => 'Mức lương đưa ra ex: trên 10 triệu, 10 triệu, dưới 10 triệu, từ 10 triệu'
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
            ->where('status', 1)
            ->orderBy('careers.updated_at', 'desc')
            ->take(10)
            ->get();
        return $careers;
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

    public function test(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cv_id = 63;
        $cv = CurriculumVitae::query()->findOrFail($cv_id);
        $filePath = $request->file('file')->storeAs('uploads', $cv->path, 'public');
        // Đọc nội dung file
        $fullPath = storage_path('app/public/' . $filePath);
        $content = file_get_contents($fullPath);
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        // Gửi nội dung tới OpenAI
        $response = $this->openAIService->analyze($content);

        // Hiển thị kết quả
        return response()->json($response['choices'][0]['text']);
    }

    public function test2(Request $request)
    {
        $cv_id = $request->cv_id;
        $cv = CurriculumVitae::query()->find($cv_id);
        $filePath = storage_path('/app/public/uploads/' . $cv->path); // Đường dẫn tới file PDF

        $prompt = 'Bạn là một trợ lý viết thư chuyên nghiệp. Nhiệm vụ của bạn là viết một bức thư giới thiệu để ứng tuyển vào một công việc, dựa trên thông tin từ CV của ứng viên được cung cấp.

            Hãy tạo một bức thư giới thiệu dạng HTML với các yêu cầu sau:
            1. Dùng các thẻ HTML cơ bản như `<h1>`, `<p>`, `<ul>` và `<strong>` để định dạng thư.
            2. Bắt đầu thư với tiêu đề lớn (dùng thẻ `<h1>`) là: "ỨNG TUYỂN VỊ TRÍ: [Tên vị trí ứng tuyển]".
            3. Giới thiệu bản thân:
            - Tên: [Tên của ứng viên] (in đậm, dùng thẻ `<strong>`).
            - Số điện thoại: [SĐT của ứng viên] (nếu không có thì để là "[SĐT của bạn]").
            - Địa chỉ: [Địa chỉ từ CV] (nếu không có thì để là "[Địa chỉ của bạn]").
            4. Dùng đoạn văn bản (thẻ `<p>`) để nêu cách ứng viên biết về vị trí tuyển dụng (ví dụ: qua website hoặc nguồn thông tin khác).
            5. Dùng một danh sách (thẻ `<ul>` và `<li>`) để trình bày lý do ứng viên tin rằng mình phù hợp với vị trí tuyển dụng.
            6. Thêm đoạn văn bản (dùng thẻ `<p>`) để bày tỏ mong muốn được phỏng vấn trong thời gian sớm nhất.
            7. Kết thúc thư bằng một lời chúc tốt đẹp (dùng thẻ `<p>`).
            8. Thêm chữ ký (dùng thẻ `<p>` hoặc `<strong>`), với định dạng:
            - Trân trọng,
            - [Tên của ứng viên].
            9. Toàn bộ nội dung được bao trong thẻ `<html>` và `<body>` để dễ gửi qua email.
            10. Nội dung phải rõ ràng, chuyên nghiệp và dễ đọc.

            Hãy trả về bức thư dưới dạng HTML hoàn chỉnh.
        ';
        $result = Gemini::generativeModel(\Gemini\Enums\ModelType::GEMINI_FLASH)
            ->generateContent([
                $prompt,
                new Blob(
                    mimeType: MimeType::APPLICATION_PDF,
                    data: base64_encode(
                        file_get_contents($filePath)
                    )
                )
            ]);
        $res = str_replace(['`', 'html', '< lang="vi">'], '', $result->text());

        return response()->json($res);

        // Loại bỏ các ký tự xuống dòng dư thừa
        $jsonString = trim($res);

        // Chuyển đổi chuỗi JSON thành mảng PHP
        $decodedJson = json_decode($jsonString);
        return response()->json($decodedJson);
    }

    public function extractInfoFromCV($cv_id)
    {
        $cv = CurriculumVitae::query()->find($cv_id);
        $filePath = storage_path('/app/public/uploads/' . $cv->path); // Đường dẫn tới file PDF

        $prompt = '"Bạn sẽ nhận một tệp PDF chứa CV của ứng viên. Nhiệm vụ của bạn là đọc và trích xuất các thông tin sau từ CV:

        Giới tính: Dựa vào cách xưng hô hoặc các thông tin khác trong CV, ví dụ Nam hoặc Nữ.
        Kỹ năng lập trình: Liệt kê các ngôn ngữ lập trình hoặc công nghệ mà ứng viên đề cập (ví dụ: PHP, NodeJS, Java, Python).
        Nơi sống: dựa vào địa chỉ được cấp trong cv vd: An Giang, TP. Hồ Chí Minh,
        Bằng cấp khác ví dụ: Toeic, MOS Office, v.v

        Trả kết quả dưới dạng cấu trúc như sau:
            Nam | PHP, NodeJS | An Giang | Toeic
        ';
        $result = Gemini::generativeModel(\Gemini\Enums\ModelType::GEMINI_FLASH)
            ->generateContent([
                $prompt,
                new Blob(
                    mimeType: MimeType::APPLICATION_PDF,
                    data: base64_encode(
                        file_get_contents($filePath)
                    )
                )
            ]);

        $result = str_replace(['\n', '\"', 'json', '`'], '', $result->text());

        return $result;
    }


    public function getInfoFromCV($cv_id)
    {
        try {

            $data = explode("|", $this->extractInfoFromCV($cv_id));


            $skillOfCv = trim($data[1]); // NodeJS,PHP
            $location = trim($data[2]);
            $certificate = trim($data[3]);
            $bestCareers = Career::query()
                ->join('career_details', 'careers.id', '=', 'career_details.career_id')
                ->select('career_details.*', 'career_details.id as id_detail', 'careers.*')
                ->whereRaw("
                MATCH(careers.title) AGAINST(? IN NATURAL LANGUAGE MODE)
                AND MATCH(careers.address) AGAINST(? IN NATURAL LANGUAGE MODE)
                AND MATCH(career_details.description, career_details.requirement) AGAINST(? IN NATURAL LANGUAGE MODE)
                ", [$skillOfCv, $location, $certificate . ' ' . $skillOfCv . ' ' . $location])
                ->get();
            $careers = Career::query()
                ->join('career_details', 'careers.id', '=', 'career_details.career_id')
                ->select('career_details.*', 'career_details.id as id_detail', 'careers.*')
                ->whereRaw("
                    MATCH(careers.title) AGAINST(? IN NATURAL LANGUAGE MODE)
                    OR MATCH(careers.address) AGAINST(? IN NATURAL LANGUAGE MODE)
                    OR MATCH(career_details.description, career_details.requirement) AGAINST(? IN NATURAL LANGUAGE MODE)
                    ", [$skillOfCv, $location, $certificate])
                ->get();
            $careers = $careers->whereNotIn('id', $bestCareers->pluck('id')->toArray());
            $careers = CareerResource::make($careers);
            $bestCareers = CareerResource::make($bestCareers);
            return response()->json([
                'success' => true,
                'careers' => $careers,
                'bestCareers' => $bestCareers,
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
