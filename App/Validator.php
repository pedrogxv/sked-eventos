<?php

namespace App;

use App\Exceptions\ValidatorException;
use Exception;

/** Esta classe é responsável por validar valores conforme as regras passadas */
final class Validator
{
    private string $current_field;

    /**
     * @param array<array, array> $rules Regras para validação.
     * @param array $values Valores que devem ser validados conforme as regras.
     */
    public function __construct(
        private readonly array $rules,
        private array          $values,
    )
    {
    }

    /**
     * Valida a instância atual.
     * @throws ValidatorException
     */
    public function validate(): bool
    {
        foreach ($this->rules as $field => $requested_rules) {
            $this->current_field = $field;

            foreach ($requested_rules as $rule) {
                // Pegando nome da regra, que pode ser neste formato -> min:10
                $rule_name = explode(":", $rule)[0];

                $function_name = "is_$rule_name";

                // Caso a regra desejada tenha um método nesta classe... execute-a
                if (method_exists($this::class, $function_name)) {
                    $rule_arguments = explode(":", $rule);
                    array_shift($rule_arguments);

                    try {
                        // Caso a regra não tenha argumentos (como o 20 neste exemplo: "min:20")
                        if (empty($rule_arguments)) !$this->$function_name($this->values[$field]);
                        else !$this->$function_name($this->values[$field], $rule_arguments[0]);
                    } catch (Exception $e) {
                        throw new ValidatorException(message: $e->getMessage(), field: $field);
                    }
                }
            }
        }

        return true;
    }

    /**
     * Checa tamanho mínimo de caracteres para um valor.
     * @throws ValidatorException
     */
    private function is_min(string $value, int $min): bool
    {
        if (strlen($value) < $min) {
            throw new ValidatorException("Campo \"$this->current_field\" deve ter tamanho mínimo de $min caracteres!");
        }

        return true;
    }

    /**
     * Checa se um valor é igual a outro valor.
     * @throws ValidatorException
     */
    private function is_equals(string $value, string $field_name): bool
    {
        if ($value !== $this->values[$field_name]) {
            throw new ValidatorException("\"$value\" não corresponde com campo: \"$field_name\"!");
        }

        return true;
    }
}
