<?php

namespace App\Http\Controllers;

use App\Enums\WorkTypeEnum;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\CandidateSingleResource;
use App\Http\Resources\CareerResource;
use App\Http\Resources\ChatResource;
use App\Http\Resources\JobAppliedResource;
use App\Models\Career;
use App\Models\Chat;
use App\Models\Company;
use App\Models\CurriculumVitae;
use App\Models\InviteInterview;
use App\Models\Notification;
use App\Models\Province;
use App\Models\ReportedUser;
use App\Models\SaveCareer;
use App\Models\User;
use App\Models\UserCareer;
use App\Models\UserProfile;
use App\Services\User\UserService;
use ConvertApi\ConvertApi;
use Exception;
use Gemini\Data\Blob;
use Gemini\Data\Candidate;
use Gemini\Enums\MimeType;
use Gemini\Enums\ModelType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function __construct(
        UserService $userService
    ) {
        $this->service = $userService;
    }

    public function index()
    {
        $messageCount = Chat::query()
            ->where('user_id', auth()->user()->id)
            ->count();
        $appliedCount = UserCareer::query()
            ->whereIn('cv_id', auth()->user()->cv()->pluck('id')->toArray())
            ->count();
        $notificationCount = Notification::query()
            ->where('user_id', auth()->user()->id)
            ->count();
        $savedJobCount = SaveCareer::query()
            ->where('user_id', auth()->user()->id)
            ->count();


        return view('pages.candidates.dashboard', compact('messageCount', 'appliedCount', 'notificationCount', 'savedJobCount'));
    }

    public function setMainCv($cvID)
    {
        $exists = CurriculumVitae::query()
            ->where('id', $cvID)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($exists) {
            auth()->user()->update([
                'main_cv' => $exists->id
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Set main CV successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Set main CV failed'
        ]);
    }

    public function jobApplied()
    {
        // lay tat ca cv cua nguoi dung
        $cvIds = auth()->user()->cv()->pluck('id')->toArray();

        // lay id cv cac job ma nguoi dung da apply
        $user_careers = UserCareer::query()->whereIn('cv_id', $cvIds)->get();

        $ids = $user_careers->pluck('career_id')->toArray();

        // lay cac job
        $careers = Career::query()->whereIn('id', $ids)->paginate(10);
        $data = JobAppliedResource::make($user_careers)->resolve();
        return view('pages.candidates.job-applied', compact('data', 'careers'));
    }

    public function profile()
    {
        return view('pages.candidates.profile');
    }

    public function myResume()
    {
        $resumeIds = CurriculumVitae::query()
            ->where('user_id', auth()->user()->id)
            ->pluck('id');
        $resumeOnSys = UserProfile::query()->whereIn('cv_id', $resumeIds)->get();
        $resumes = CurriculumVitae::query()
            ->whereNotIn('id', $resumeOnSys->pluck('cv_id')->toArray())
            ->where('user_id', auth()->user()->id)
            ->get();
        return view('pages.candidates.my-resume', compact('resumes', 'resumeOnSys'));
    }

    public function savedJob()
    {
        $ids = auth()->user()->saveJob()->pluck('career_id')->toArray();
        $careers = Career::query()
            ->whereIn('id', $ids)
            ->where('deleted_at', null)
            ->get();
        $data = CareerResource::make($careers)->resolve();
        return view('pages.candidates.saved-job', compact('careers', 'data'));
    }

    public function processSavedJob(Request $request)
    {
        $career_id = $request->career_id;
        $user_id = auth()->id();

        $career = Career::query()->findOrFail($career_id);

        if ($career->deleted_at != null || $career->status != 1) {
            return response()->json([
                'success' => false,
                'msg' => 'Job Not Found'
            ], 400);
        }

        // Kiểm tra xem đã lưu công việc chưa
        $exist = SaveCareer::where([
            'career_id' => $career_id,
            'user_id' => $user_id
        ])->first();

        // Nếu đã tồn tại, xóa bản ghi
        if ($exist) {
            $exist->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Job removed successfully'
            ]);
        }

        // Nếu chưa tồn tại, tạo bản ghi mới
        $savedJob = SaveCareer::create([
            'career_id' => $career_id,
            'user_id' => $user_id
        ]);

        // Kiểm tra tạo bản ghi thành công
        return response()->json([
            'success' => (bool) $savedJob,
            'msg' => $savedJob ? 'Job Applied Successfully' : 'Failed to apply for job'
        ], $savedJob ? 200 : 400);
    }

    public function uploadCV(Request $request)
    {
        // Validate file upload
        $request->validate([
            'file' => 'required|mimes:pdf|max:5000', // Tùy chỉnh loại file và kích thước
            'html' => 'nullable',
            'profile_id' => 'nullable',
            'objective' => 'nullable',
            'education' => 'nullable',
            'exp' => 'nullable',
            'language' => 'nullable',
            'certificate' => 'nullable',
            'skill' => 'nullable',
            'soft_skill' => 'nullable',
            'position' => 'nullable',
            'province' => 'nullable',
            'phone' => 'nullable',
            'birthday' => 'nullable',
            'email' => 'nullable',
            'avatar' => 'nullable',
        ]);
        $careerSuggest = [];
        $userProfile = '';
        $cvCreated = null;
        // Lưu file vào storage/app/public/uploads
        try {
            if ($request->file()) {
                DB::beginTransaction();

                $fileName = time() . '_' . $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $this->pdfToImg($fileName);

                // Neu nguoi dung tao cv tren he thong
                if ($request->html) {
                    $request['exp'] = $this->handleExpAttr($request);

                    // Kiem tra neu nguoi dung dang update cv
                    if ($request->profile_id) {
                        $userProfile = UserProfile::query()->find($request->profile_id);
                        $userProfile->update([
                            'content' => $request->html,
                            'objective' => $request->objective,
                            'education' => $request->education,
                            'exp' => $request->exp,
                            'language' => $request->language,
                            'certificate' => $request->certificate,
                            'skill' => $request->skill,
                            'soft_skill' => $request->soft_skill,
                            'position' => $request->position,
                            'province' => $request->province,
                            'phone' => $request->phone,
                            'birthday' => $request->birthday,
                            'email' => $request->email,
                            'avatar' => $request->avatar,
                        ]);
                        $cv = CurriculumVitae::query()->where('id', $userProfile->cv_id)->first();
                        unlink(storage_path('app/public/uploads/' . $cv->path));
                        unlink(storage_path('app/public/uploads/' . $cv->thumbnail));
                        $cv->update([
                            'path' => $fileName,
                            'thumbnail' => 'img-cv/' . $fileName . '.png',
                        ]);
                    } else {
                        $cv = CurriculumVitae::query()->create([
                            'user_id' => auth()->user()->id,
                            'path' => $fileName,
                            'thumbnail' => 'img-cv/' . $fileName . '.png',
                        ]);

                        $userProfile = UserProfile::query()->create([
                            'content' => $request->html,
                            'cv_id' => $cv->id,
                            'objective' => $request->objective,
                            'education' => $request->education,
                            'exp' => $request->exp,
                            'language' => $request->language,
                            'certificate' => $request->certificate,
                            'skill' => $request->skill,
                            'soft_skill' => $request->soft_skill,
                            'position' => $request->position,
                            'province' => $request->province,
                            'phone' => $request->phone,
                            'birthday' => $request->birthday,
                            'email' => $request->email,
                            'avatar' => $request->avatar,
                        ]);

                        //                        $careerSuggest = $this->matchWithJob($cv->id);
                    }
                } else {
                    $cvCreated = CurriculumVitae::query()->create([
                        'user_id' => auth()->user()->id,
                        'path' => $fileName,
                        'thumbnail' => 'img-cv/' . $fileName . '.png',
                    ]);
                }
                DB::commit();
                Session::flash('response', [
                    'success' => true,
                    'msg' => 'File has been uploaded successfully!',
                    'file_name' => $fileName,
                    'file_path' => asset('storage/' . $filePath),
                    'career_suggest' => $careerSuggest,
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'File has been uploaded successfully!',
                    'cv' => $cvCreated,
                    'redirect_url' => route('candidate.create-cv', $userProfile->id ?? 0)
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => false,
            'msg' => 'File upload failed.'
        ], 500);
    }

    public function handleExpAttr(Request $request)
    {
        $data = $request->all();
        $exp = $data['exp'];
        $exp = explode("|", $exp);
        unset($exp[0], $exp[1]);
        $exp = implode("|", $exp);


        return $exp;
    }

    public function pdfToImg($pdfName)
    {
        $path = storage_path('app/public/uploads/' . $pdfName);
        $pathImg = storage_path('app/public/uploads/img-cv/' . $pdfName . '.png');
        ConvertApi::setApiCredentials('jwS8EwQy8QsTlY6O');
        $result = ConvertApi::convert(
            'png',
            [
                'File' => $path,
                'PageRange' => '1-1',
            ],
            'pdf'
        );
        $result->saveFiles($pathImg);
    }

    public function uploadAvatar(Request $request)
    {
        // Validate input
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'type' => 'nullable',
        ]);
        // Lưu file vào thư mục 'public/images'
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/avatar'), $imageName);

                if (!$request->type) {
                    auth()->user()->update([
                        'avatar' => $imageName
                    ]);
                }
                // Trả về phản hồi JSON
                return response()->json(['msg' => 'Image uploaded successfully.', 'image' => $imageName]);
            }
        } catch (\Exception $exception) {
            return response()->json(['msg' => $exception->getMessage()], 400);
        }
    }
    public function uploadAvatarCompany(Request $request)
    {
        // Validate input
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
            'type' => 'nullable'
        ]);
        // Lưu file vào thư mục 'public/images'
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/avatar/company'), $imageName);

                if ($request->has('type')) {
                    auth()->guard('company')->user()->update([
                        'banner' => 'company/' . $imageName
                    ]);
                } else {
                    auth()->guard('company')->user()->update([
                        'company_avatar' => 'company/' . $imageName
                    ]);
                }
                // Trả về phản hồi JSON
                return response()->json(['msg' => 'Image uploaded successfully.', 'image' => $imageName]);
            }
        } catch (\Exception $exception) {
            return response()->json(['msg' => $exception->getMessage()], 400);
        }
    }

    public function createCV($id = null)
    {
        $response = null;
        if (Session::has('response')) {
            $response = Session::get('response');
        }
        $userProfile = UserProfile::query()->find($id);
        return view('pages.candidates.create-cv', compact('userProfile', 'response'));
    }

    public function storeCV() {}

    public function deleteCV($cvID)
    {
        try {
            DB::beginTransaction();
            $cv = CurriculumVitae::query()->where('id', $cvID)->first();
            if ($cv) {
                $cv->delete();
                unlink(storage_path('app/public/uploads/' . $cv->path));
                unlink(storage_path('app/public/uploads/' . $cv->thumbnail));
            } else {
                throw new \Exception('This cv does not exist');
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'File deleted successfully!'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['msg' => $exception->getMessage()], 500);
        }
    }

    public function matchWithJob($cvId)
    {
        try {
            $cv = UserProfile::query()->where('cv_id', $cvId)->first();
            $skillOfCv = $cv->skill; // NodeJS,PHP
            $location = $cv->province;
            $certificate = $cv->certificate;
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

    public function reportCandidate(Request $request)
    {
        if (strlen($request->report_content) > 100) {
            return response()->json([
                'success' => false,
                'msg' => 'Content must not exceed 100 characters'
            ], 500);
        }
        $candidate = User::query()->find($request->candidate_id);
        $company = auth()->guard('company')->user();
        $existReport = ReportedUser::query()->where([
            'user_id' => $candidate->id,
            'company_id' => $company->id
        ])->first();

        if ($existReport) {
            return response()->json([
                'success' => false,
                'msg' => 'You have reported this candidate!'
            ], 500);
        }
        $reportedUser = null;
        if ($candidate) {
            $uploadedFiles = [];
            // Lưu các file lên Cloudinary hoặc lưu vào storage
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $uploadedFileUrl = cloudinary()->upload($file->getRealPath())->getSecurePath();
                    // Lưu thông tin URL vào mảng để trả về
                    $uploadedFiles[] = $uploadedFileUrl;
                }
            }
            ReportedUser::query()->create([
                'user_id' => $candidate->id,
                'company_id' => $company->id,
                'report_content' => $request->report_content,
                'images' => json_encode($uploadedFiles),
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Report successfully submitted!'
            ]);
        }



        return response()->json([
            'success' => false,
            'msg' => 'Something went wrong!'
        ], 404);
    }

    public function showReviewCV()
    {
        $cvs = CurriculumVitae::query()->where('user_id', auth()->user()->id)->get();
        return view('pages.candidates.review-cv', compact('cvs'));
    }

    public function reviewCV(Request $request)
    {
        $cv = CurriculumVitae::query()->findOrFail($request->cvId);
        if (!$cv || $cv->path == null) {
            return response()->json([
                'message' => 'CV not found !'
            ], 500);
        }
        $filePath = storage_path('/app/public/uploads/' . $cv->path); // Đường dẫn tới file PDF
        $pdfContent = base64_encode(file_get_contents($filePath));
        $language = App::getLocale() == 'en' ? 'tiếng anh' : 'tiếng việt';
        $lang = [
            trans('lang.achievement'),
            trans('lang.experience'),
            trans('lang.language'),
            trans('lang.Soft Skill'),
            trans('lang.skill'),
            trans('lang.Career Goal')
        ];
        $lang = implode(' ,', $lang);
        $prompt = 'Hãy phân tích CV và xuất đầu ra dưới dạng JSON. Các key sẽ là các mục lớn như ' . $lang . ', v.v. Bất kỳ mục lớn nào bạn nhận thấy trong CV, hãy liệt kê đầy đủ. Mỗi key sẽ có một trường bổ sung để mô tả tên mục đó dưới dạng ngôn ngữ tự nhiên, ví dụ: career_goal sẽ có một trường field chứa "Career Goal". Đầu ra sẽ bao gồm 3 mục chính: score (đánh giá trên thang điểm 10), reason (lý do), suggestion (gợi ý cải thiện).
        Hãy đảm bảo rằng mọi thông tin phân tích đều chính xác và có thể cải thiện. Trả lời chỉ bằng ' . $language . ' và chuỗi json không trả lời thêm bất cứ thứ gì khác
        Ví dụ đầu ra: [
                {
                    "personal_info": {
                    "score": 5,
                    "reason": "Thiếu thông tin như ngày sinh và địa chỉ.",
                    "suggestion": "Cung cấp đầy đủ thông tin cá nhân bao gồm ngày sinh và địa chỉ để tạo sự tin cậy.",
                    "field": "Thông Tin Cá Nhân"
                    }
                },
                {
                    "career_goal": {
                    "score": 7,
                    "reason": "Mục tiêu nghề nghiệp rõ ràng nhưng chưa thể hiện sự đột phá.",
                    "suggestion": "Thêm các mục tiêu dài hạn và kế hoạch phát triển để thể hiện tầm nhìn nghề nghiệp.",
                    "field": "Mục Tiêu Nghề Nghiệp"
                    }
                }
        ]';

        // OPEN AI
        //        $client = \OpenAI::factory()
        //            ->withBaseUri('https://open.keyai.shop/v1')
        //            ->withApiKey(env('OPENAI_API_KEY'))
        //            ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 60]))
        //            ->make();
        //        $createParms = [
        //            'model'=>'gpt-4-vision-preview',
        //            'messages'=>[
        //                [
        //                    'role'=>'system', 'content'=>'Your system message like you are a helpful AI assistant'
        //                ],
        //                [
        //                    'role' => 'user',
        //                    'content' => [
        //                        [
        //                            'type' => 'text',
        //                            'text' => $prompt
        //                        ],
        //                        [
        //                            'type' => 'image_url',
        //                            'image_url' => [
        //                                'url' => $pdfContent
        //                            ]
        //                        ]
        //                    ]
        //                ]
        //
        //            ],
        //            'max_tokens' => 1000
        //        ];
        //        $result = $client->chat()->create($createParms);
        // GEMINI
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
        $res = str_replace(['`', 'json'], '', $result->text());
        //        $res = str_replace(['`', 'json'], '', $result['choices'][0]['message']['content']);
        $res = json_decode($res);


        return response()->json($res);
    }

    public function showAppointment()
    {
        return view('pages.candidates.appointment');
    }

    public function showChat()
    {

        $latestMessages = Chat::query()
            ->select('chats.*')
            ->where('user_id', auth()->user()->id)
            ->join(
                DB::raw('(SELECT MAX(id) as latest_id FROM chats WHERE user_id = ' . auth()->user()->id . ' GROUP BY company_id) as latest'),
                'chats.id',
                '=',
                'latest.latest_id'
            )
            ->orderBy('created_at', 'desc')
            ->get();
        $latestMessages = ChatResource::make($latestMessages)->resolve();
        return view('pages.candidates.chat', [
            'latestMessages' => $latestMessages
        ]);
    }

    public function showListCandidate(Request $request)
    {
        $candidates = User::query();

        if ($request['search']) {
            $candidates = $candidates->where('fullname', 'like', '%' . $request['search'] . '%');
            Session::flash('keyword', $request['search']);
        }
        if ($request->has('job-type') && $request->input('job-type') != 'all') {
            // Chuyển chuỗi 'job_type' thành mảng
            $jobTypeFilter = explode(',', $request->input('job-type'));
            Session::flash('job-type', $request['job-type']);
            // Lọc theo các giá trị trong mảng $jobTypeFilter
            $candidates = $candidates->whereIn('type_work', array_map(function ($jobType) {
                return WorkTypeEnum::getValue($jobType); // Áp dụng enum mapping
            }, $jobTypeFilter));
        }

        if ($request->has('locations')) {
            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $candidates = $candidates->whereIn('province_id', $locationIds);
        }

        $candidates = $candidates->paginate(10);
        $data = CandidateResource::make($candidates);
        return view('pages.candidates.candidate-list', [
            'data' => $data->resolve(),
            'candidates' => $candidates
        ]);
    }

    public function showDetailCandidate($candidateId)
    {
        $candidate = User::query()->where('id', $candidateId)->get();
        $candidate = CandidateResource::make($candidate)->resolve()[0];
        return view('pages.candidates.candidate-detail', compact('candidate'));
    }

    public function acceptInterview(Request $request)
    {
        $code = $request->query('code');

        $inviteExists = InviteInterview::query()->where('code', $code)->first();

        if ($inviteExists && !$inviteExists->status) {
            $inviteExists->status = 1;
            $inviteExists->accepted_at = Carbon::now()->toDateTimeString();
            $inviteExists->save();
            return view('pages.candidates.accept-invite');
        }

        return redirect()->route('home');
    }

    public function downloadCV($user_id)
    {
        $user = User::query()->where('id', $user_id)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 500);
        }

        if ($user->ban) {
            return response()->json([
                'message' => 'This user has been banned !'
            ], 500);
        }

        if ($user->main_cv == null) {
            return response()->json([
                'message' => 'CV not found !'
            ], 500);
        }
        $cv = CurriculumVitae::query()->where('id', $user->main_cv)->first();
        if (!$cv || $cv->path == null) {
            return response()->json([
                'message' => 'CV not found !'
            ], 500);
        }
        // Tạo đường dẫn công khai tới file
        $fileUrl = asset('storage/uploads/' . $cv->path);
        return response()->json([
            'message' => 'File link generated successfully.',
            'file_url' => $fileUrl
        ], 200);
    }
}
