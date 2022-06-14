<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Verify a user's account
     *
     * @param  int  $uid
     * @return \Illuminate\Http\Response
     */
    public function verify($uid, Request $request)
    {
        // Confirm if the verfication url is valid
        if (!$request->hasValidSignature()) {
            return $this->miuResponse(false, 'VERIFICATION_URL_INVALID');
        }

        $user = User::find($uid);
        if ($user) {
            if ($user->hasVerifiedEmail()) {
                return $this->miuResponse(false, 'ACCOUNT_ALREADY_VERIFIED');
            } else {
                $user->markEmailAsVerified();
                return $this->miuResponse(true, 'ACCOUNT_VERIFIED');
            }
        }

        return $this->miuResponse(false, 'ACCOUNT_NOT_FOUND');
    }

    /**
     * Resend a verification link
     *
     * @param  string  $prefix
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $email = $request->get('email');
        if (!$email) return $this->miuResponse(false, 'INVALID_EMAIL_ADDRESS');

        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->hasVerifiedEmail()) {
                return $this->miuResponse(false, 'ACCOUNT_ALREADY_VERIFIED');
            } else {
                $user->sendEmailVerificationNotification();

                return $this->miuResponse(true, 'VERIFICATION_SENT');
            }
        }

        return $this->miuResponse(false, 'ACCOUNT_NOT_FOUND');
    }
}
