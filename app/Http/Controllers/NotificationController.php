<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function readMessage(): void
    {
        Notification::query()->where('user_id', auth()->user()->id)->update(['read' => 1]);
    }

    public function readMessageCompany(): void
    {
        Notification::query()->where('company_id', Session::get('company')->id)->update(['read' => 1]);

    }
}
