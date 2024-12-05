<?php

namespace App\Http\Controllers;

use App\Mail\TestSendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function showLogin($type)
    {
        return Socialite::driver($type)->redirect();
    }

    public function handleCallback($type)
    {
        $user = Socialite::driver($type)->user();
        $this->handleLogin($user);

        return redirect()->route('home');

    }

    public function handleLogin($user)
    {
        $exist = User::query()->where('email', $user->email)->first();
        try {
            if (!$exist) {
                $title = 'Đăng ký thành công tài khoản !';
                $password = bin2hex(random_bytes(6));
                $hassPass = Hash::make($password);

                $userCreate = User::query()->create([
                    'fullname' => $user->name ?? $user->nickname,
                    'email' => $user->email,
                    'password' => $hassPass,
                ]);
                Auth::login($userCreate);
                Mail::to($user->email)->send(new TestSendMail($title, $password));

            } else {
                if ($exist->ban) {
                    return redirect()->route('home');
                }
                Auth::login($exist);

            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }

    }
}
