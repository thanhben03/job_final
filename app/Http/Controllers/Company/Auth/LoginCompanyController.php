<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\CompanyLoginRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginCompanyController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.company-login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(CompanyLoginRequest $request): RedirectResponse
    {
//        $data = $request->validated();
//        $exist = Company::query()->where('company_email', $data['company_email'])->first();
//        if (Hash::check($data['company_password'], $exist->company_password)) {
//            Session::put('company', $exist);
//        } else {
//            dd('Failed');
//        }
//        return redirect()->intended(route('company.dashboard', absolute: false));
        try {
            $request->authenticate();

            $request->session()->regenerate();
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }

        return redirect()->intended(route('company.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('company')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}
