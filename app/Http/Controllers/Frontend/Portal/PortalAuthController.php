<?php

namespace App\Http\Controllers\Frontend\Portal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PortalAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('frontend.pages.portal-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput()->with('error', 'بيانات الدخول غير صحيحة.');
        }

        $student = Student::where('user_id', Auth::id())->first();
        if (! $student) {
            Auth::logout();
            return back()->withInput()->with('error', 'هذا الحساب ليس حساب طالب.');
        }

        $request->session()->regenerate();

        return redirect()->route('portal.dashboard');
    }

    public function dashboard(): View
    {
        $student = Student::where('user_id', Auth::id())->with('program.college')->firstOrFail();

        return view('frontend.pages.portal-dashboard', compact('student'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
