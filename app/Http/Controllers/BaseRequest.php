<?php


namespace App\Http\Controllers;


use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Validate the request before authorize() function
     */
    public function validateResolved()
    {
        $validator = $this->getValidatorInstance();

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        }
    }
}
