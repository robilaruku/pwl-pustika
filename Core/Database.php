<?php

namespace Core;

final class Database
{
    /** @var \PDO */
    private static $conn = null;

    /**
     * Get PDO connection instance as per DB_CONFIG in App\Config
     *
     * @return \PDO
     */
    public static function getConnection()
    {
        if (is_null(self::$conn)) {
            $c = app()->getConfig()::DB_CONFIG;

            $dsn = "mysql:host={$c['host']};dbname={$c['dbname']};";
            if (isset($c['port'])) {
                $dsn .= "port={$c['port']};";
            }

            self::$conn = new \PDO(
                $dsn,
                $c['username'],
                $c['password']
            );
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}