<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // ✅ Registration function using Factory-created User
    public function register(User $user, $type = 'passenger') {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $hashedPassword = password_hash($user->password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssss", $user->name, $user->email, $hashedPassword, $type);
        return $stmt->execute();
    }

    // ✅ Login function
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                return [
                    'success' => true,
                    'user' => $user
                ];
            }
        }

        return ['success' => false];
    }
}
?>
