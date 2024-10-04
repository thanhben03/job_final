<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\CurriculumVitae;
use App\Models\SaveCareer;
use App\Models\UserCareer;
use App\Models\UserProfile;
use App\Services\User\UserService;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\PdfToImage\Pdf;

class CandidateController extends Controller
{
    public function __construct(
        UserService $userService
    )
    {
        $this->service = $userService;
    }

    public function index()
    {
        return view('pages.candidates.dashboard');
    }

    public function jobApplied()
    {
        // lay tat ca cv cua nguoi dung
        $cvIds = auth()->user()->cv()->pluck('id')->toArray();

        // lay id cv cac job ma nguoi dung da apply
        $ids = UserCareer::query()->whereIn('cv_id', $cvIds)->pluck('career_id')->toArray();

        // lay cac job
        $careers = Career::query()->whereIn('id', $ids)->paginate(10);
        $data = CareerResource::make($careers)->resolve();

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
            ->get();
        return view('pages.candidates.my-resume', compact('resumes', 'resumeOnSys'));
    }

    public function savedJob()
    {
        $ids = auth()->user()->saveJob()->pluck('career_id')->toArray();
        $careers = Career::query()->whereIn('id', $ids)->get();
        $data = CareerResource::make($careers)->resolve();
        return view('pages.candidates.saved-job', compact('careers', 'data'));
    }

    public function processSavedJob(Request $request)
    {
        $career_id = $request->career_id;
        $user_id = auth()->id();

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
        ]);
        $request['exp'] = $this->handleExpAttr($request);
        $this->matchWithJob();
        // Lưu file vào storage/app/public/uploads
        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $this->pdfToImg($fileName);

            if ($request->html) {
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
                    ]);
                    $cv = CurriculumVitae::query()->where('id', $userProfile->cv_id)->first();
                    unlink(storage_path('app/public/uploads/' . $cv->path));
                    unlink(storage_path('app/public/uploads/'. $cv->thumbnail));
                    $cv->update([
                        'path' => $fileName,
                        'thumbnail' => 'img-cv/' . $fileName. '.png',
                    ]);
                } else {
                    $cv = CurriculumVitae::query()->create([
                        'user_id' => auth()->user()->id,
                        'path' => $fileName,
                        'thumbnail' => 'img-cv/' . $fileName. '.png',
                    ]);

                    UserProfile::query()->create([
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
                    ]);
                }
            } else {
                CurriculumVitae::query()->create([
                    'user_id' => auth()->user()->id,
                    'path' => $fileName,
                    'thumbnail' => 'img-cv/' . $fileName. '.png',
                ]);
            }



            return response()->json([
                'success' => true,
                'msg' => 'File has been uploaded successfully!',
                'file_name' => $fileName,
                'file_path' => asset('storage/' . $filePath)
            ], 200);
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
        $path = storage_path('app/public/uploads/'. $pdfName);
        $pathImg = storage_path('app/public/uploads/img-cv/'. $pdfName . '.png');
        ConvertApi::setApiCredentials('jwS8EwQy8QsTlY6O');
        $result = ConvertApi::convert('png', [
            'File' => $path,
            'PageRange' => '1-1',
        ], 'pdf'
        );
        $result->saveFiles($pathImg);
    }

    public function uploadAvatar(Request $request)
    {
        // Validate input
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);
        // Lưu file vào thư mục 'public/images'
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/avatar'), $imageName);

                auth()->user()->update([
                    'avatar' => $imageName
                ]);
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
        ]);
        // Lưu file vào thư mục 'public/images'
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/avatar/company'), $imageName);

                Session::get('company')->update([
                    'company_avatar' => 'company/' . $imageName
                ]);
                // Trả về phản hồi JSON
                return response()->json(['msg' => 'Image uploaded successfully.', 'image' => $imageName]);
            }
        } catch (\Exception $exception) {
            return response()->json(['msg' => $exception->getMessage()], 400);
        }

    }

    public function createCV($id = null)
    {
        $userProfile = UserProfile::query()->find($id);
        return view('pages.candidates.create-cv', compact('userProfile'));
    }

    public function storeCV()
    {

    }

    public function deleteCV($cvID)
    {
        try {
            DB::beginTransaction();
            $cv = CurriculumVitae::query()->findOrFail($cvID);
            if ($cv) {
                unlink(storage_path('app/public/uploads/' . $cv->path));
                unlink(storage_path('app/public/uploads/'. $cv->thumbnail));

                $cv->delete();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'File deleted successfully!'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['msg' => $exception->getMessage()], 400);
        }



    }

    public function matchWithJob($cvId)
    {
        try {
            $cv = UserProfile::query()->where('cv_id', $cvId)->first();
            $skillOfCv = $cv->skill; // NodeJS,PHP
            $certificate = $cv->certificate;
            $careers = Career::query('careers')
                ->join('career_details', 'careers.id', '=', 'career_details.career_id')
                ->whereRaw("
            MATCH(careers.title) AGAINST(? IN NATURAL LANGUAGE MODE)
            OR MATCH(career_details.description, career_details.requirement) AGAINST(? IN NATURAL LANGUAGE MODE)
        ", [$skillOfCv, $certificate])
                ->get();
            $careers = CareerResource::make($careers);
            return response()->json([
                'success' => true,
                'careers' => $careers
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }


}
