<?php

namespace App\Http\Controllers;

use App\Events\AppointmentAcceptEvent;
use App\Events\AppointmentEvent;
use App\Http\Resources\AppointmentResource;
use App\Mail\CancelAppointmentMail;
use App\Mail\InterviewScheduleUpdatedMail;
use App\Mail\NewAppointmentMail;
use App\Models\Career;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'note' => 'nullable|string',
            'career_id' => 'required|exists:careers,id',
        ]);
        $validated['company_id'] = auth()->guard('company')->user()->id;

        $existingAppointment = Appointment::query()
            ->where('user_id', $validated['user_id'])
            ->where('career_id', $validated['career_id'])
            ->where('status', 'pending')
            ->first();
        $user = User::query()->find($validated['user_id']);
        if (!$user || $user->ban) {
            return response()->json(['message' => 'Đã xảy ra lỗi với ứng viên này !'], 400);
        }
        $job = Career::query()->findOrFail($validated['career_id']);
        if (!$job) {
            return response()->json(['message' => 'Đã xảy ra lỗi đối với công việc này !'], 409);
        }
        if ($existingAppointment) {
            return response()->json(['message' => 'Lịch hẹn đã tồn tại cho ứng viên này!'], 409);
        }
        $appointment = Appointment::query()->create($validated);
        $message = Notification::query()->create([
            'user_id' => $validated['user_id'],
            'message' => 'Bạn có môt lịch hẹn chờ phản hồi từ ' . auth()->guard('company')->user()->company_name,
            'from_id' => auth()->guard('company')->user()->id,
        ]);
        $data = [
            'date_time' => $validated['date'] . ' ' . $validated['time'],
            'email' => auth()->guard('company')->user()->email,
            'note' => $validated['note'],
            'candidate_name' => $user->fullname,
            'title' => $job->title,
        ];
        Mail::to($user->email)->send(new NewAppointmentMail($data));
        broadcast(new AppointmentEvent($validated['user_id'], $message->message))->toOthers();

        return response()->json(['success' => 'Lịch hẹn đã được tạo thành công!']);
    }


    // Phương thức để ứng viên đồng ý cuộc hẹn
    public function acceptAppointment($id)
    {
        $appointment = Appointment::query()->where('id', $id)->first();
        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found !'
            ], 500);
        }

        if ($appointment->status != 'pending') {
            return response()->json([
                'message' => 'Appointment not found !'
            ], 500);
        }

        if ($appointment->company->ban) {
            return response()->json([
                'message' => 'This company cannot be found at the moment!'
            ], 500);
        }
        $appointment->status = 'accepted';
        $appointment->save();

        $notification = Notification::query()->create([
            'company_id' => $appointment->company_id,
            'message' => "Ứng viên [" . $appointment->user->fullname . "] đã đồng ý lịch hẹn của bạn !",
            'from_id' => $appointment->user_id,
        ]);
        broadcast(new AppointmentAcceptEvent($appointment->company_id, $notification->message))->toOthers();
        return response()->json(['success' => 'Bạn đã đồng ý cuộc hẹn.']);
    }

    // Phương thức để ứng viên từ chối cuộc hẹn
    public function rejectAppointment($id)
    {
        $appointment = Appointment::query()->where('id', $id)->first();
        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found !'
            ], 500);
        }

        if ($appointment->status != 'pending') {
            return response()->json([
                'message' => 'Appointment not found !'
            ], 500);
        }

        if ($appointment->company->ban) {
            return response()->json([
                'message' => 'This company cannot be found at the moment!'
            ], 500);
        }
        $appointment->status = 'rejected';
        $appointment->save();

        return response()->json(['success' => 'Bạn đã từ chối cuộc hẹn.']);
    }

    public function cancel(Request $request)
    {
        $appointment = Appointment::query()->find($request->id);
        $appointment->status = 'cancel';
        $appointment->save();
        $data = [
            'date_time' => $appointment->date . ' ' . $appointment->time,
            'reason' => $request->reason,
            'candidate_name' => $appointment->user->fullname,
            'email' => $appointment->company->email,
            'company_name' => $appointment->company->company_name,
        ];
        Mail::to($appointment->user->email)->send(
            new CancelAppointmentMail($data)
        );
        return response()->json(['success' => 'Bạn đã từ chối cuộc hẹn.']);
    }

    // Lấy danh sách các cuộc hẹn của ứng viên
    public function getAppointments($user_id)
    {
        $appointments = Appointment::where('user_id', $user_id)->with(['company', 'career'])->get();
        $appointments = AppointmentResource::make($appointments);
        return response()->json($appointments);
    }

    public function updateAppointment(Request $request, $appointmentId)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'reason' => 'nullable'
        ]);

        // Kết hợp ngày và giờ mới để kiểm tra
        $newDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);

        // Lấy thời gian hiện tại
        $now = Carbon::now();

        // Kiểm tra nếu thời gian mới phải trước thời gian hiện tại
        if ($newDateTime->isPast()) {
            return response()->json(['error' => 'Ngày và giờ phải trước thời điểm hiện tại.'], 422);
        }

        $appointment = Appointment::find($appointmentId);
        if ($appointment->status == 'rejected') {
            return response()->json(['error' => 'Ứng viên đã từ chối lịch hẹn này !'], 422);
        }
        if ($appointment) {
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->status = 'pending'; // Đặt trạng thái thành pending
            $appointment->save();
            $data = [
                'new_date_time' => $newDateTime,
                'reason' => $request->reason,
                'candidate_name' => $appointment->user->fullname,
                'email' => $appointment->company->email,
                'company_name' => $appointment->company->company_name,
            ];
            Mail::to($appointment->user->email)->send(
                new InterviewScheduleUpdatedMail($data)
            );

            return response()->json(['success' => 'Ngày và giờ cuộc hẹn đã được cập nhật.']);
        } else {
            return response()->json(['error' => 'Không tìm thấy cuộc hẹn.'], 404);
        }
    }
}
