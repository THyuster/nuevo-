<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ValidStringOrImage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value)) {
            return;
        }

        if ($value instanceof UploadedFile) {
            if ($value->isValid() && in_array($value->extension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                return;
            };
        }
        
        $fail('The :attribute debe ser una imagen o una cadena.');
    }
}
