<?php

namespace Core;

class Model
{
    /** @var string Table Name */
    protected $table = null;


    /** @var string Primary Key Column */
    protected $key = "id";


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
     * @param array $columns Columns to be retirved
     * @param int $fetchStyle PDO fetch style constatnt
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
            // If column and value are provided, use the where method
            $stmt = Database::getConnection()->prepare("SELECT * FROM {$this->table} WHERE `$column` = ? LIMIT 1");
            $stmt->execute([$value]);
        } else {
            // If no column and value are provided, get the first record
            $stmt = Database::getConnection()->prepare("SELECT * FROM {$this->table} LIMIT 1");
            $stmt->execute();
        }

        // Fetch and return the first record
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }


    /**
     * Get all row from db table
     *
     * @param array $columns Columns to be retirved
     * @param int $fetchStyle PDO fetch style constatnt
     * @return array
     */
    public function all($columns = ['*'], $fetchStyle = \PDO::FETCH_BOTH)
    {
        $columns = implode(",", $columns);
        $stmt = Database::getConnection()
            ->prepare("SELECT $columns FROM $this->table");
        $stmt->execute();
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
     * Delete row from fb table witn given id
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
}