<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkTypeEnum;
use App\Events\MessageSentEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChatResource;
use App\Http\Resources\Api\ListCVResource;
use App\Http\Resources\ChatSingleResource;
use App\Http\Resources\CVResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\Company;
use App\Models\CurriculumVitae;
use App\Models\Notification;
use App\Models\Province;
use App\Models\User;
use App\Models\UserProfile;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function getAllCV($user_id)
    {
        $cvs = CurriculumVitae::query()->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        $cvs = ListCVResource::make($cvs);
        return response()->json($cvs);
    }

    public function infoSystem()
    {
        $provinces = Province::all()->pluck('name', 'code');
        $workType = WorkTypeEnum::getLabels();
        $workTypeConvert = [];

        foreach ($workType as $key => $value) {
            $workTypeConvert[] = [
                'key' => $key,
                'value' => $value
            ];
        }

        return response()->json([
            'provinces' => $provinces,
            'workType' => $workTypeConvert
        ]);
    }

    public function updateProfile(Request $request)
    {
        $dataUser = $request->except('workExperiences', 'id');
        $dataExperience = $request->only('workExperiences');
        $user = User::query()->find($request->id);
        $user->update($dataUser);
        $user->save();

        if ($user) {
            try {
                DB::beginTransaction();

                if (count($dataExperience) > 0) {
                    $user->experiences()->delete();
                    foreach ($dataExperience['workExperiences'] as $value) {
                        $user->experiences()->create([
                            'from_date' => $value['from_date'],
                            'to_date' => $value['to_date'],
                            'title' => $value['title'],
                            'position' => $value['position'],
                            'description' => $value['description'],
                            'user_id' => $request->id
                        ]);
                    }
                }

                DB::commit();
                $user = UserResource::make($user);
                return response()->json(['msg' => 'Cập nhật thành công!', 'user' => $user]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['msg' => $th->getMessage()], 500);
            }
        }
    }

    public function notifications($user_id) {
        try {
            $notifications = Notification::query()->where('user_id', $user_id)->get();
            $notifications = NotificationResource::make($notifications);

            return response()->json($notifications);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteAllNotifications ($id) {
        try {
            Notification::query()->where('user_id', $id)->delete();

            return response()->json([
                'msg' => 'Xóa thông báo thành công !',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => $th->getMessage(),
            ], 500);
        }
    }

    public function setDefaultCV(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::query()->findOrFail($request->user_id);
            $user->main_cv = $request->cvId;
            $user->save();
            DB::commit();
            return response()->json([
                'msg' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function uploadCV(Request $request)
    {
        try {
            if ($request->file()) {
                DB::beginTransaction();
                $user = User::query()->findOrFail($request->user_id);
                $fileName = time() . '_' . $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $this->pdfToImg($fileName);

                $cv = CurriculumVitae::query()->create([
                    'user_id' => $user->id,
                    'path' => $fileName,
                    'thumbnail' => 'img-cv/' . $fileName . '.png',
                ]);
                DB::commit();

                return response()->json([
                    'success' => true,
                    'msg' => 'File has been uploaded successfully!',
                    'cv' => CVResource::make($cv)->resolve()
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 500);
        }
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
            'user_id' => 'required'
        ]);
        // Lưu file vào thư mục 'public/images'
        try {
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/avatar'), $imageName);
                $user = User::query()->findOrFail($request->user_id);
                $user->avatar = $imageName;
                $user->save();

                // Trả về phản hồi JSON
                return response()->json([
                    'msg' => 'Image uploaded successfully.',
                    'image' => env('APP_URL').'/images/avatar/'.$imageName
                ]
                );
            }
        } catch (\Exception $exception) {
            return response()->json(['msg' => $exception->getMessage()], 400);
        }
    }

    public function getAllChatByUser(Request $request, $user_id)
    {
        $latestMessages = Chat::query()
            ->select('chats.*')
            ->where('user_id', $user_id)
            ->join(
                DB::raw('(SELECT MAX(id) as latest_id FROM chats WHERE user_id = ' . $user_id . ' GROUP BY company_id) as latest'),
                'chats.id',
                '=',
                'latest.latest_id'
            )
            ->orderBy('created_at', 'desc')
            ->get();
        $latestMessages = ChatResource::make($latestMessages)->resolve();
        return response()->json($latestMessages);
    }

    public function getDetailChat($user_id, $company_id)
    {
        $chats = Chat::query()
            ->select('chats.*')
            ->where([
                'user_id' => $user_id,
                'company_id' => $company_id
            ])
            ->get();

        $chats = ChatResource::make($chats)->resolve();
        return response()->json($chats);
    }

    public function sendMessageToCompany(Request $request)
    {
        $user = User::query()->findOrFail($request->user_id);
        $company_id = $request->company_id;
        $message = $request->message;

        $company = Company::query()->find($request->company_id);


        $message = Chat::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'message' => $message,
            'sender' => 'user'
        ]);

        $noti = Notification::query()->create([
            'message' => 'Bạn có một tin nhắn mới từ ['.$user->fullname.']',
            'company_id' => $company->id,
            'from_id' => $user->id,
        ]);

        broadcast(new NotificationEvent($company->id, $noti->message))->toOthers();
        broadcast(new MessageSentEvent($message))->toOthers();

        $message = ChatSingleResource::make($message)->resolve();
        return response()->json($message);
    }


}
