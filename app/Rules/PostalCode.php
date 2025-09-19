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
            case 'GB':
                $valid = preg_match('/^[A-Za-z]{1,2}\d{1,2}[A-Za-z]?\s?\d[A-Za-z]{2}$/i', $value);
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
                $valid = preg_match('/^[1-9][0-9]{3}\s?[A-Za-z]{2}$/i', $value);
                $message = 'Invalid Netherlands postal code. Must be 4 digits followed by 2 letters (e.g., 1234 AB or 1234AB).';
                break;
            // Europe
            case 'DE': // Germany
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid German postal code. Must be 5 digits.';
                break;
            case 'FR': // France
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid French postal code. Must be 5 digits.';
                break;
            case 'ES': // Spain
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Spanish postal code. Must be 5 digits.';
                break;
            case 'IT': // Italy
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Italian postal code. Must be 5 digits.';
                break;
            case 'PT': // Portugal
                $valid = preg_match('/^\d{4}-\d{3}$/', $value);
                $message = 'Invalid Portuguese postal code. Must be in the format 1234-567.';
                break;
            case 'SE': // Sweden
                $valid = preg_match('/^\d{3}\s?\d{2}$/', $value);
                $message = 'Invalid Swedish postal code. Must be 5 digits (e.g., 123 45 or 12345).';
                break;
            case 'NO': // Norway
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Norwegian postal code. Must be 4 digits.';
                break;
            case 'DK': // Denmark
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Danish postal code. Must be 4 digits.';
                break;
            case 'FI': // Finland
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Finnish postal code. Must be 5 digits.';
                break;
            case 'BE': // Belgium
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Belgian postal code. Must be 4 digits.';
                break;
            case 'CH': // Switzerland
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Swiss postal code. Must be 4 digits.';
                break;
            case 'AT': // Austria
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Austrian postal code. Must be 4 digits.';
                break;
            case 'IE': // Ireland
                $valid = preg_match('/^[A-Za-z0-9]{3}\s?[A-Za-z0-9]{4}$/i', $value);
                $message = 'Invalid Irish postal code. Must be in the format A65 F4E2 or D6W ABCD.';
                break;
            case 'PL': // Poland
                $valid = preg_match('/^\d{2}-\d{3}$/', $value);
                $message = 'Invalid Polish postal code. Must be in the format 12-345.';
                break;
            case 'CZ': // Czech Republic
                $valid = preg_match('/^\d{3}\s?\d{2}$/', $value);
                $message = 'Invalid Czech postal code. Must be 5 digits (e.g., 123 45 or 12345).';
                break;
            case 'HU': // Hungary
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Hungarian postal code. Must be 4 digits.';
                break;
            case 'GR': // Greece
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Greek postal code. Must be 5 digits.';
                break;
            case 'RO': // Romania
                $valid = preg_match('/^\d{6}$/', $value);
                $message = 'Invalid Romanian postal code. Must be 6 digits.';
                break;

            // South America
            case 'BR': // Brazil
                $valid = preg_match('/^\d{5}-\d{3}$/', $value);
                $message = 'Invalid Brazilian postal code. Must be in the format 12345-678.';
                break;
            case 'AR': // Argentina
                $valid = preg_match('/^[A-Za-z]\d{4}[A-Za-z]{3}$/i', $value);
                $message = 'Invalid Argentine postal code. Must be in the format A1234ABC.';
                break;
            case 'CL': // Chile
                $valid = preg_match('/^\d{7}$/', $value);
                $message = 'Invalid Chilean postal code. Must be 7 digits.';
                break;
            case 'CO': // Colombia
                $valid = preg_match('/^\d{6}$/', $value);
                $message = 'Invalid Colombian postal code. Must be 6 digits.';
                break;
            case 'PE': // Peru
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Peruvian postal code. Must be 5 digits.';
                break;
            case 'VE': // Venezuela
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Venezuelan postal code. Must be 4 digits.';
                break;
            case 'EC': // Ecuador
                $valid = preg_match('/^\d{6}$/', $value);
                $message = 'Invalid Ecuadorian postal code. Must be 6 digits.';
                break;
            case 'UY': // Uruguay
                $valid = preg_match('/^\d{5}$/', $value);
                $message = 'Invalid Uruguayan postal code. Must be 5 digits.';
                break;
            case 'PY': // Paraguay
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Paraguayan postal code. Must be 4 digits.';
                break;
            case 'BO': // Bolivia
                $valid = preg_match('/^\d{4}$/', $value);
                $message = 'Invalid Bolivian postal code. Must be 4 digits.';
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
