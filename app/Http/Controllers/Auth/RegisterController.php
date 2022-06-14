<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request) {
        /* Recaptcha V3, Email, Username, Password, Confirm Password */

        $form = $request->validated();
        $form['password'] = Hash::make($form['password']);

        // New user created
        $user = new User($form);
        $user->save();

        // Send out email
        $user->sendEmailVerificationNotification();

        return $this->miuResponse(true, 'ACCOUNT_REGISTERED', $user);
    }
}
