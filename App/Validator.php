<?php

namespace App;

use App\Exceptions\ValidatorException;
use DateTime;
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

    /**
     * Checa se um valor requerido é vazio.
     * @throws ValidatorException
     */
    private function is_required(string $value): bool
    {
        if (!$value) {
            throw new ValidatorException("Campo " . ucfirst($this->current_field) . " não pode ser vazio!");
        }

        return true;
    }


    /**
     * Checa se um valor é um DateTime baseado no formato 8601.
     * @throws ValidatorException
     */
    private function is_datetime(string $value): bool
    {
        $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $value);

        if (!$dateTime) {
            throw new ValidatorException("Campo " . ucfirst($this->current_field) . " não pôde ser validado como um formato de data válido no padrão ISO 8601!");
        }

        return true;
    }

    /**
     * Checa se o valor é uma string.
     * @throws ValidatorException
     */
    private function is_string(mixed $value): bool
    {
        if (gettype($value) !== "string") {
            throw new ValidatorException("Campo " . ucfirst($this->current_field) . " deve ser do tipo string (texto)!");
        }

        return true;
    }

    /**
     * Checa se a data solicitada é depois (maior) que a data comparada.
     * @throws ValidatorException
     */
    private function is_after(string $date, string $comparator): bool
    {
        $date = new DateTime($date);
        $dateCompared = new DateTime(strtotime($comparator));

        // Caso esteja comparando com um valor existente no vetor de valores a serem validados...
        if (isset($this->values[$comparator])) {
            $dateCompared = new DateTime($this->values[$comparator]);
        }

        // Se a data não for maior que a data comparada...
        if ($date < $dateCompared) {
            throw new ValidatorException(
                "Data do campo " . ucfirst($this->current_field) . " deve ser maior que " . ucfirst($comparator) . "!"
            );
        }

        return true;
    }
}
