<?php

namespace App\Http\Requests\Api;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'reservation_id' => 'required|exists:reservations,id',
            'meals' => 'required|array',
            'meals.*.meal_id' => 'required|exists:meals,id|distinct',
            'meals.*.quantity' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
            'reservation_id.required' => 'Reservation ID is required.',
            'meals.required' => 'You must provide at least one meal.',
            'meals.*.meal_id.exists' => 'The selected meal does not exist.',
            'meals.*.quantity.min' => 'The quantity must be at least 1.',
        ];
    }

    public function attributes()
    {
        return [
            'customer_id' => 'Customer ID',
            'reservation_id' => 'Reservation ID',
            'meals.*.meal_id' => 'Meal ID',
            'meals.*.quantity' => 'Meal Quantity',
        ];
    }
}