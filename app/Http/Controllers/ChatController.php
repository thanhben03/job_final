<?php

namespace App\Http\Controllers;

use App\Events\MessagePresent;
use App\Events\MessageSentEvent;
use App\Events\NotificationEvent;
use App\Http\Resources\ChatResource;
use App\Http\Resources\ChatSingleResource;
use App\Models\Chat;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    public function sendMessageToUser(Request $request)
    {
        $company = Company::query()->where('id', '=',Auth::guard('company')->user()->id)->first();
        $message = $request->message;

        $user = User::query()->find($request->user_id);


        $message = Chat::query()->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'message' => $message,
            'sender' => 'company'
        ]);

        $noti = Notification::query()->create([
            'message' => 'Bạn có một tin nhắn mới từ ['.$company->company_name.']',
            'user_id' => $user->id,
            'from_id' => $company->id,
        ]);

        broadcast(new NotificationEvent($user->id, $noti->message));
        broadcast(new MessageSentEvent($message))->toOthers();
        broadcast(new MessagePresent($message))->toOthers();
        $message = ChatSingleResource::make($message)->resolve();
        return response()->json($message);

    }

    public function sendMessageToCompany(Request $request)
    {
        $user = auth()->user();
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



    public function viewChatForUser($companyId)
    {
        // Update the most recent message to mark it as read and then retrieve all messages
        Chat::where('company_id', $companyId)
            ->where([
                'user_id' => auth()->id(),
                'company_id' => $companyId
            ])
            ->latest('id') // Sort by 'id' in descending order and take the latest record
            ->first() // Get the most recent message
            ->update(['read' => 1]); // Update the 'read' status

        // Retrieve all messages after the update
        $messages = Chat::where('company_id', $companyId)
            ->where('user_id', auth()->id())
            ->get();

        $messages = ChatResource::make($messages)->resolve();
        return response()->json($messages);
    }

    public function viewChatForCompany($userId)
    {
        // Update the most recent message to mark it as read and then retrieve all messages
        Chat::query()
            ->where([
                'user_id' => $userId,
                'company_id' => Auth::guard('company')->user()->id,
                'sender' => 'user'
            ])
            ->latest('id') // Sort by 'id' in descending order and take the latest record
            ->first() // Get the most recent message
            ->update(['read' => 1]); // Update the 'read' status

        // Retrieve all messages after the update
        $messages = Chat::where('company_id', Auth::guard('company')->user()->id)
            ->where('user_id', $userId)
            ->get();
        $messages = ChatResource::make($messages)->resolve();
        return response()->json($messages);
    }

    public function quickChat(Request $request)
    {

    }
}
