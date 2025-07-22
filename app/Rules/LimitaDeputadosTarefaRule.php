<?php

namespace App\Rules;

use App\Models\Deputados;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LimitaDeputadosTarefaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $deputado = Deputados::withCount('tarefas')->find($value);

        if ($deputado->tarefas_count >= 5) {
            $fail("Não é possível atribuir mais tarefas ao deputado selecionado, pois ele já atingiu o limite permitido.");
        }
    }
}
