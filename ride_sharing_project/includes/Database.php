<?php
class Database {
    private static $instance = null;
    private $connection;

    // Private constructor to prevent direct object creation
    private function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "ride_sharing");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Get the instance of the Database class
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the database connection
    public function getConnection() {
        return $this->connection;
    }
}
?>
