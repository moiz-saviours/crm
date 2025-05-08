<?php

namespace App\Http\Requests;

use App\Rules\PostalCode;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PaymentValidatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'card_number' => 'required|numeric',
            'expiry_month' => 'required|date_format:m',
            'expiry_year' => 'required|date_format:Y',
            'cvv' => 'required|numeric',
            'invoice_number' => 'required|numeric|exists:invoices,invoice_key',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|regex:/^\+?\d{0,3}?[-.\s]?\(?\d{1,4}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/',
            'zipcode' => ['required', 'string', new PostalCode($this->input('country'))],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'card_number.numeric' => 'The Card number must be numeric.',
            'card_number.required' => 'Card number is required.',
            'expiry_month.required' => 'Expiration month is required.',
            'expiry_month.date_format' => 'Expiration month format is invalid.',
            'expiry_year.required' => 'Expiration year is required.',
            'expiry_year.date_format' => 'Expiration year format is invalid.',
            'cvv.required' => 'The CVV number field is required.',
            'cvv.numeric' => 'The CVV number must be numeric.',
            'invoice_number.required' => 'Invoice number is required.',
            'invoice_number.numeric' => 'Invalid invoice number.',
            'invoice_number.exists' => 'Invoice not found.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a valid string.',
            'address.max' => 'The address must not exceed 255 characters.',
            'city.required' => 'The city field is required.',
            'city.string' => 'The city must be a valid string.',
            'city.max' => 'The city must not exceed 100 characters.',
            'state.required' => 'The state field is required.',
            'state.string' => 'The state must be a valid string.',
            'state.max' => 'The state must not exceed 100 characters.',
            'country.required' => 'The country field is required.',
            'country.string' => 'The country must be a valid string.',
            'country.max' => 'The country must not exceed 100 characters.',
            'phone.required' => 'The phone number field is required.',
            'phone.regex' => 'The phone number must be a valid international phone number.',
            'zipcode.required' => 'The zipcode field is required.',
            'zipcode.string' => 'The zipcode must be a valid string.',
            'zipcode.regex' => 'The zipcode format is invalid. It must be 5 digits or 5+4 digits (e.g., 12345 or 12345-6789).',
        ];
    }
}
