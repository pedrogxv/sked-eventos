<?php

namespace App\Concerns;

use App\Database\PDOConnector;
use App\Exceptions\ValidatorException;
use App\Validator;
use PDO;

abstract class Model
{
    /** Nome do modelo (Usado como nome de tabela no banco de dados) */
    public string $name = "";

    /** Campos do modelo que podem ser atribuídos em massa */
    protected array $fillable = [];

    /** Define as regras para existência de cada atributo */
    protected array $rules = [];

    /** Retorna todos os registros do Modelo (Model). */
    public function all(): array
    {
        $query = "SELECT * FROM $this->name";

        $con = PDOConnector::getConnector()->prepare($query);
        $con->execute();

        return $con->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /** Retorna um registro baseado na cláusula where passada no parâmetro */
    public function getWhere(string $whereClause): array
    {
        $query = "SELECT * FROM $this->name WHERE $whereClause";

        $con = PDOConnector::getConnector()->prepare($query);
        $con->execute();

        return $con->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Salva um registro no banco de dados
     * @throws ValidatorException
     */
    public function save(array $data): bool
    {
        // Validando dados.
        try {
            (new Validator($this->rules, $data))
                ->validate();
        } catch (ValidatorException $e) {
            return throw new $e;
        }

        $fields = rtrim(
            implode(", ", array_keys($data)), ", "
        );

        $values = "";

        foreach ($data as $name => $value) {
            $values .= "\"$value\", ";
        }

        $values = rtrim($values, ", ");

        $query = "INSERT INTO $this->name ($fields) VALUES ($values);";
        var_dump($query);

        $con = PDOConnector::getConnector()->prepare($query);

        return $con->execute();
    }

    /** Deleta um registro do banco de dados */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM $this->name WHERE id = $id";

        $statement = PDOConnector::getConnector()
            ->prepare($sql);

        return $statement->execute();
    }
}