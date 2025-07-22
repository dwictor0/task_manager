<?php

namespace App\Rules;

use App\Models\SugestaoVotos;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidaVotosRule implements ValidationRule
{
  
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userId = Auth::id();

        $validaVotos = SugestaoVotos::where('sugestao_id', $value)
            ->where('usuario_id', $userId)
            ->exists();


        if ($validaVotos) {
            $fail("Você já votou nessa sugestão");
        }
      
    }
}
