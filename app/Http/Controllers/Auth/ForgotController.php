<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request) {
        $form = $request->validate();

        if (User::where('email', $form['email'])->first()) {
            // Send a new link for a password reset to the user
            Password::sendResetLink($form['email']);
            return $this->miuResponse(true, 'RESENT_LINK');
        }

        return $this->miuResponse(false, 'USER_NOT_FOUND');
    }

    public function reset(ResetRequest $request) {
        $form = $request->validate();

        // Attempt to reset password, bcrypt
        $resetAttempt = Password::reset($form, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        // Token invalid, let the user know
        if ($resetAttempt == Password::INVALID_TOKEN) {
            return $this->miuResponse(false, 'INVALID_TOKEN');
        }

        return $this->miuResponse(true, 'UPDATED_PASSWORD');
    }
}
