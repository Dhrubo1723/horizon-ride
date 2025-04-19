<?php
require_once 'Database.php';
session_start();

abstract class User {
    protected $name;
    protected $email;
    protected $phone_number;
    protected $password;
    protected $type;

    public function register() {
        $db = Database::getInstance()->getConnection();
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert the basic user info into the 'users' table
        $query = "INSERT INTO users (name, email, phone_number, password, type) 
                  VALUES ('$this->name', '$this->email', '$this->phone_number', '$hashedPassword', '$this->type')";
        $db->query($query);

        // Get the last inserted user ID
        $userID = $db->insert_id;

        // Call subclass method to insert specific user info (Driver/Passenger/Admin)
        $this->saveAdditionalInfo($userID);
    }

    public abstract function saveAdditionalInfo($userID);

    public function login() {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM users WHERE email='$this->email'";

        $result = $db->query($query);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($this->password, $user['password'])) {
                $_SESSION['user'] = $user['email'];
                $_SESSION['user_type'] = $user['type'];
                echo "Login successful!";
                header("Location: dashboard.php");
            } else {
                echo "Invalid credentials!";
            }
        } else {
            echo "No user found with that email!";
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        echo "Logged out successfully!";
        header("Location: login.php");
    }
}
?>
