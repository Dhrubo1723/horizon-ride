
<?php
class Database {
    private static $instance = null;
    private $conn;

    private $db_server = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "sharing";  // your DB name

    // Make constructor private so no one can create object from outside
    private function __construct() {
        $this->conn = new mysqli(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_name
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // This method returns the same instance always
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database(); // Create only if not exists
        }
        return self::$instance;
    }

    // Gives access to the actual connection
    public function getConnection() {
        return $this->conn;
    }
}
?>

