<?php
namespace API\Core;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        global $db;
        if (!isset($db) || !($db instanceof \mysqli)) {
            throw new \Exception("Database connection not properly initialized");
        }
        $this->connection = $db;
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \mysqli {
        return $this->connection;
    }

    public function prepare(string $query): \mysqli_stmt {
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->connection->error);
        }
        return $stmt;
    }

    public function beginTransaction(): void {
        $this->connection->begin_transaction();
    }

    public function commit(): void {
        $this->connection->commit();
    }

    public function rollback(): void {
        $this->connection->rollback();
    }
}
