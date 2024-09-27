<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\CurriculumVitae;
use App\Models\SaveCareer;
use App\Models\UserCareer;
use App\Services\User\UserService;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
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
        $resumes = CurriculumVitae::query()->where('user_id', auth()->user()->id)->get();
        return view('pages.candidates.my-resume', compact('resumes'));
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
        ]);

        // Lưu file vào storage/app/public/uploads
        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $this->pdfToImg($fileName);

            CurriculumVitae::query()->create([
                'user_id' => auth()->user()->id,
                'path' => $fileName,
                'thumbnail' => 'img-cv/' . $fileName. '.png',
            ]);

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
}
