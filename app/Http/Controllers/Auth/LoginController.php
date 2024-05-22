<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();

            // Query the bans table
            $ban = \DB::table('bans')->where('user_id', $user->id)->first();

            // Check if a ban record is found and the ban is not expired
            if ($ban && $ban->expired_at > now()) {
                $this->guard()->logout();
                $request->session()->invalidate();

                return $this->sendFailedLoginResponse($request, 'User: ' . $user->name . ' is banned until ' . $ban->expired_at);
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request, $message)
    {
        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}
