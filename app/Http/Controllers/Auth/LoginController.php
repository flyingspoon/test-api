<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(LoginRequest $request) {
        /* Recaptcha V3, Username, Password */

        $form = $request->validated();

        // // Email or Password
        if (!auth()->attempt(['email' => $form['name'], 'password' => $form['password']]) &&
            !auth()->attempt(['name' => $form['name'], 'password' => $form['password']])
        ) return $this->miuResponse(false, 'INVALID_CREDENTIALS');

        if (!auth()->user()->hasVerifiedEmail()) {
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return $this->miuResponse(false, 'UNVERIFIED_ACCOUNT');
        }
                
        // Making sure its a fresh session
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->regenerate();
        
        return response()->json([], 201);
    }

    /**
     * Logging out
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // To use cookies, we need to use web guard, to access CSRF etc

        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(null, 200);
    }
}
