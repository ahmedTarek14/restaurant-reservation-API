<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservationAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_response_error($validator->errors()->first()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'from_time' => 'required|date|after_or_equal:' . now()->startOfDay(),
            'to_time' => 'required|date|after:from_time|after_or_equal:' . now(),
            'number_of_guests' => 'required|integer|min:1',

        ];
    }

    public function attributes()
    {
        return [
            'from_time' => 'From Time',
            'to_time' => 'To Time',
            'number_of_guests' => 'Number Of Guests',

        ];
    }
}