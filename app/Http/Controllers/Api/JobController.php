<?php

namespace App\Http\Controllers\Api;

use App\Events\AppointmentAcceptEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Resources\Api\AppliedJobResource;
use App\Http\Resources\Api\AppointmentResource;
use App\Http\Resources\CareerDetailResource;
use App\Http\Resources\CareerResource;
use App\Http\Resources\SavedJobResource;
use App\Models\Appointment;
use App\Models\Career;
use App\Models\Notification;
use App\Models\Province;
use App\Models\ReportedCareer;
use App\Models\SaveCareer;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function __construct(CareerServiceInterface $careerService)
    {
        $this->service = $careerService;
    }

    public function index()
    {
        $careers = $this->service->getAll()->take(5);
        $careers = CareerResource::make($careers)->resolve();
        return response()->json($careers);
    }

    public function getAll(Request $request)
    {
        $careers = Career::query();
        if ($request->has('search')) {
            $careers->where('title', 'like', '%' . $request->get('search') . '%');
        }
        if ($request->has('category_id')) {
            $careers->where('category_id', $request->get('category_id'));
            Session::flash('category_id', $request['category_id']);
        }

        if ($request->has('locations')) {
            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $careers = $careers->whereIn('province_id', $locationIds);
        }
        if ($request->has('skills')) {
            $skillFilter = explode(',', $request['skills']);
            Session::flash('skills', $request['skills']);

            $skillIds = Skill::query()->whereIn('name', $skillFilter)->pluck('id')->toArray();
            $careers = $careers->hasSkills($skillIds);
        }

        $careers = $careers->paginate(10);
        $data = CareerResource::make($careers)->resolve();
        return response()->json([
            'jobs' => $data,
            'total' => $careers->total()
        ]);
    }


    public function show($jobId)
    {
        $job = Career::query()->where('id', $jobId)->get();
        $job = CareerResource::make($job)->resolve()[0];
        return response()->json($job);
    }


    public function applyJob(ApplyJobRequest $request)
    {
        $data = $request->validated();
        $today = now();

        try {
            $job = Career::query()->findOrFail($data['job_id']);

            // Neu thoi gian ung tuyen da het
            if ($today->greaterThan($job->expiration_day)) {
                return response()->json([
                    'msg' => 'Application period has expired!'
                ], 500);
            }
            $userCareer = UserCareer::query()->where([
                'career_id' => $data['job_id'],
                'cv_id' => $data['cv_id'],
            ])->first();

            if ($userCareer) {
                return response()->json([
                    'msg' => 'You have already applied for this job'
                ], 500);
            }
            UserCareer::query()->create([
                'career_id' => $data['job_id'],
                'cv_id' => $data['cv_id'],
            ]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'msg' => $th->getMessage()
            ], 500);
        }
    }

    public function saveJob(Request $request)
    {

        $career_id = $request->career_id;
        $user_id = $request->user_id;

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

    public function reportJob(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
            'user_id' => 'required|exists:users,id',
        ]);
        try {
            $existJob = Career::query()->findOrFail($request->input('career_id'));
            $existReport = ReportedCareer::query()->where([
                'career_id' => $existJob->id,
                'user_id' => $request->user_id
            ])->first();
            if ($existReport) {
                throw new \Exception('You have already reported this job!');
            }

            ReportedCareer::query()->create([
                'career_id' => $existJob->id,
                'user_id' => $request->user_id

            ]);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function getSavedJob($user_id)
    {
        $user = User::query()->findOrFail($user_id);
        $savedJob = $user->saveJob;
        $data = SavedJobResource::make($savedJob)->resolve();

        return response()->json($data);
    }

    public function getAppliedJob($user_id)
    {
        $user = User::query()->findOrFail($user_id);
        // lay tat ca cv cua nguoi dung
        $cvIds = $user->cv()->pluck('id')->toArray();

        // lay id cv cac job ma nguoi dung da apply
        $user_carreers = UserCareer::query()->whereIn('cv_id', $cvIds)->get();

        $careers = AppliedJobResource::make($user_carreers);


        return response()->json($careers);
    }

    public function getAppointment($user_id)
    {
        $appointments = Appointment::query()->where('user_id', $user_id)->get();
        $appointments = AppointmentResource::make($appointments);

        return response()->json($appointments);
    }

    public function updateAppointment(Request $request)
    {
        $appointment = Appointment::query()->findOrFail($request->id);
        $appointment->status = $request->status;
        $appointment->save();

        // $notification = Notification::query()->create([
        //     'company_id' => $appointment->company_id,
        //     'message' => "Ứng viên [" . $appointment->user->fullname . "] đã đồng ý lịch hẹn của bạn !",
        //     'from_id' => $appointment->user_id,
        // ]);
        // broadcast(new AppointmentAcceptEvent($appointment->company_id, $notification->message))->toOthers();
    }
}
