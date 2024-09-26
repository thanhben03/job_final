<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::query()->create($request->validated());

            return response()->json([
                'user' => $user,
                'msg' => 'Register successfully'
            ]);


//            return re()->back()->with([
//                'msg' => 'Register successfully',
//                'alert-class' => 'alert-success'
//            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'msg' => $exception->getMessage(),
            ], 400);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            return back();
        }

    }
}
