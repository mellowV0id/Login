<?php

class Database
{
    /**
     * @var string
     */
    private CONST USER = "profondoRosso";

    /**
     * @var string
     */
    private const PASSWORD = "VoltarenUpMyAss@";

    /**
     * @var string
     */
    private const DSN = "mysql:host=localhost;dbname=first_database";

    /**
     * @var PDO
     */
    private PDO $connection;

    public function __construct()
    {
        try {
            if(!isset($this->connection)) {
                $this->connection = new PDO(
                    self::DSN,
                    self::USER,
                    self::PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_PERSISTENT => false,
                    ]
                );
            }
        } catch (PDOException $e) {
            throw new PDOException('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $whereKeyValuePair
     *
     * @return array
     */
    public function select(string $table, array $columns = ['*'], array $whereKeyValuePair = []): array
    {
        if (empty(trim($table))) {
            return [];
        }

        if (empty($columns)) {
            $columns = '*';
        } else {
            $columns = implode(',', $columns);
        }

        $where = "";
        if (!empty($whereKeyValuePair)) {
            $where    = "WHERE ";
            $iterator = 1;
            foreach ($whereKeyValuePair as $key => $value) {
                $where .= "$key = :$key";

                if (count($whereKeyValuePair) > 1 && $iterator < count($whereKeyValuePair)) {
                    $where .= " AND ";
                }

                $iterator++;
            }
        }

        $stmt = $this->connection->prepare("SELECT $columns FROM $table $where");

        foreach ($whereKeyValuePair as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return [];
        }

        return $result;
    }

    /**
     * @param string $table
     * @param array $columnValuePairs
     * @return bool
     */
    public function insert(string $table, array $columnValuePairs): bool
    {
        if (empty(trim($table))) {
            return false;
        }

        if (empty($columnValuePairs)) {
            return false;
        }

        $values   = '';
        $columns  = '';
        $iterator = 1;

        foreach ($columnValuePairs as $column => $value) {
            $columns .= $column;

            if (count($columnValuePairs) > $iterator) {
                $columns .= ', ';
            }

            $values .= "'" . $value . "'";

            if (count($columnValuePairs) > $iterator) {
                $values .= ', ';
            }

            $iterator++;
        }

        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->connection->query($query);

        return true;
    }

    /**
     * Update data from the Db table
     * @param string $table
     * @param array $columnValuePairs
     * @return bool
     */
    public function update(string $table, array $columnValuePairs, string $where): bool
    {
        if (empty(trim($table))) {
            return false;
        }
        if (empty($columnValuePairs)) {
            return false;
        }

        $update = '';
        $i      = 1;

        foreach ($columnValuePairs as $column => $value) {
            $update .= "`$column`" . ' = ' . "'$value'";

            if (count($columnValuePairs) > $i) {
                $update .= ', ';
            }

            $i++;
        }

        $this->connection->query("UPDATE $table SET $update WHERE $where");

        return true;
    }
}
