<?php

namespace Core;

class Model
{
    /** @var string Table Name */
    protected $table = null;

    /** @var string Primary Key Column */
    protected $key = "id";

    /** @var string SQL query string */
    protected $query = '';

    /** @var array Query parameters */
    protected $params = [];

    /** @var array Selected columns */
    protected $selectColumns = ['*'];

    /** @var array Joined tables */
    protected $joins = [];

    public function __construct()
    {
        if (is_null($this->table)) {
            $this->table = explode("\\", get_called_class());
            $this->table = end($this->table);
            $this->table = substr($this->table, -1) === 'y' ?
                rtrim($this->table, 'y') . 'ies' : $this->table . 's';
            $this->table = lcfirst($this->table);
        }
    }

    /**
     * Get row from db table with id
     *
     * @param int $id Id value
     * @param array $columns Columns to be retrieved
     * @param int $fetchStyle PDO fetch style constant
     * @return mixed
     */
    public function find($id, $columns = ['*'], $fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $columns);
        $stmt = Database::getConnection()
            ->prepare("SELECT $columns FROM $this->table WHERE $this->key=?");
        $stmt->execute([$id]);
        return $stmt->fetch($fetchStyle);
    }

    /**
     * Get a record where column matches value
     *
     * @param string $column
     * @param mixed $value
     * @param int $fetchStyle PDO fetch style constant
     * @return mixed
     */
    public function where($column, $value, $fetchStyle = \PDO::FETCH_BOTH)
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM {$this->table} WHERE `$column` = ?");
        $stmt->execute([$value]);
        return $stmt->fetch($fetchStyle);
    }

    /**
     * Fetch the first record from the query with optional conditions
     *
     * @param string|null $column Optional column to filter by
     * @param mixed|null $value Optional value to filter by
     * @return mixed
     */
    public function first($column = null, $value = null)
    {
        if ($column && $value) {
            $stmt = Database::getConnection()->prepare("SELECT * FROM {$this->table} WHERE `$column` = ? LIMIT 1");
            $stmt->execute([$value]);
        } else {
            $stmt = Database::getConnection()->prepare("SELECT * FROM {$this->table} LIMIT 1");
            $stmt->execute();
        }

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get all rows from db table
     *
     * @param array $columns Columns to be retrieved
     * @param int $fetchStyle PDO fetch style constant
     * @return array
     */
    public function all($columns = ['*'], $fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $columns);
        $stmt = Database::getConnection()
            ->prepare("SELECT $columns FROM $this->table" . $this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll($fetchStyle);
    }

    /**
     * Update db row with $id with given values
     *
     * @param int $id
     * @param array $data associative array containing columns and values
     * @return boolean
     */
    public function update($id, $data)
    {
        $columns = implode('=?, ', array_keys($data)) . '=?';
        return Database::getConnection()
            ->prepare("UPDATE $this->table SET $columns WHERE $this->key=?")
            ->execute(array_merge(array_values($data), [$id]));
    }

    /**
     * Delete row from db table with given id
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return Database::getConnection()
            ->prepare("DELETE FROM $this->table WHERE $this->key=?")
            ->execute([$id]);
    }

    /**
     * Create a row in db table
     *
     * @param array $data associative array containing columns and values
     * @return boolean
     */
    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        return Database::getConnection()
            ->prepare("INSERT INTO $this->table ($columns) VALUES ($values)")
            ->execute(array_values($data));
    }

    /**
     * Join another table
     *
     * @param string $table Table to join
     * @param string $first First column to join
     * @param string $operator Operator for join
     * @param string $second Second column to join
     * @return $this
     */
    public function join($table, $first, $operator, $second)
    {
        $this->joins[] = "JOIN $table ON $first $operator $second";
        return $this;
    }

    /**
     * Add a WHERE clause to the query
     *
     * @param string $column Column name
     * @param mixed $value Value to filter by
     * @return $this
     */
    public function whereClause($column, $value)
    {
        // Check if a WHERE clause already exists in the query
        if (strpos($this->query, 'WHERE') === false) {
            $this->query .= " WHERE `$column` = ?";
        } else {
            $this->query .= " AND `$column` = ?";
        }
        $this->params[] = $value;
        return $this;
    }

    /**
     * Specify the columns to be retrieved
     *
     * @param array $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->selectColumns = $columns;
        return $this;
    }

    /**
     * Get data with the current query
     *
     * @param int $fetchStyle PDO fetch style constant
     * @return array
     */
    public function get($fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $this->selectColumns);
        $joins = implode(' ', $this->joins); // Join all tables
        $sql = "SELECT $columns FROM $this->table $joins" . $this->query;
        error_log("SQL Query: " . $sql); // Log the SQL query
        error_log("Parameters: " . json_encode($this->params)); // Log the parameters
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($this->params);
        $this->resetQuery(); // Reset query and params after execution
        return $stmt->fetchAll($fetchStyle);
    }

    /**
     * Reset query and parameters
     *
     * @return void
     */
    protected function resetQuery()
    {
        $this->query = '';
        $this->params = [];
        $this->selectColumns = ['*'];
        $this->joins = []; // Reset joins
    }
}
