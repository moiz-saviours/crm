<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostalCode implements ValidationRule
{
    protected string $country;

    public function __construct(string $country)
    {
        $this->country = strtoupper($country);
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string)$value;
        $valid = false;
        $message = 'Invalid postal code format.';
        switch ($this->country) {
            case 'US':
                $valid = preg_match('/^\d{5}(-\d{4})?$/', $value);
                $message = 'Invalid US zip code. Must be 5 digits (e.g., 12345) or 9 digits (e.g., 12345-6789).';
                break;
            case 'CA':
                $valid = preg_match('/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/i', $value);
                $message = 'Invalid Canadian postal code. Must be in the format A1A 1A1.';
                break;
            case 'UK':
                $valid = preg_match('/^[A-Za-z]{1,2}\d{1,2}[A-Za-z]? \d[A-Za-z]{2}$/i', $value);
                $message = 'Invalid UK postal code. Must be in the format A1 1AA, A11 1AA, AA1 1AA, or AA11 1AA.';
                break;
            case 'IN':
                $valid = preg_match('/^\d{6}$/', $value);
                $message = 'Invalid Indian postal code. Must be 6 digits.';
                break;
            case 'AU':
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Australian postal code. Must be 4 digits.';
                break;
            case 'NL':
                $valid = preg_match('/^\d{4}\s?[A-Za-z]{2}$/i', $value);
                $message = 'Invalid Netherlands postal code. Must be 4 digits followed by 2 letters (e.g., 1234 AB or 1234AB).';
                break;
            default:
                $fail("Postal code validation not supported for country: {$this->country}");
                return;
        }
        if (!$valid) {
            $fail($message);
        }
    }
}
