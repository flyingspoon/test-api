<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function miuResponse($status, $message, $data = null) {
        $builder = [];
        $builder['status'] = $status;
        $builder['message'] = $message;
        $builder['data'] = $data;

        return $builder;
    }

    public function handleValidation($form) {
        $errors_cache = [];

        if ($form->fails()) {
            $errors = $form->errors()->messages();
            foreach ($errors AS $key => $value) {
                $errors_cache[] = [
                    'field' => $key,
                    'message' => $value[0]
                ];
            }

            return $this->miuResponse(
                false,
                'FAILED_VALIDATION',
                $errors_cache
            );
        }

        return false;
    }
}
