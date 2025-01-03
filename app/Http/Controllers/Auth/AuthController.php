<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
  /**
   * Display the login view.
   */
  public function create(): Response
  {
    return Inertia::render('Auth/Login', [
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
    ]);
  }

  /**
   * Handle an incoming authentication request.
   * @param LoginRequest $request
   * @return RedirectResponse
   */
  public function store(LoginRequest $request): RedirectResponse
  {
    $request->authenticate();

    if (! $this->userCanAccess(Auth::user())) {
      Auth::logout();
      return redirect()->route('login')->withErrors(['identifier' => 'Anda tidak memiliki akses ke halaman ini.']);
    }

    $request->session()->regenerate();

    return redirect()->intended(route('beranda'));
  }

  /**
   * Destroy an authenticated session.
   * @param Request $request
   * @return RedirectResponse
   */
  public function destroy(Request $request): RedirectResponse
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }

  /**
   * Check if the user can access the page.
   * @param $user
   * @return Booelan
   */
  private function userCanAccess($user): bool
  {
    return $user && $user->role != 0;
  }
}
