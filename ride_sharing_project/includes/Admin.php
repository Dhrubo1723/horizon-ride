<?php
require_once 'User.php';

class Admin extends User {
    public function __construct($name, $email, $phone_number, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->type = 'admin';
    }

    // No additional info needed for admin
    public function saveAdditionalInfo($userID) {
        // Admin-specific details can be saved here if needed
    }

    // Display Admin registration form
    public function displayForm() {
        echo '<form method="POST">
                <input type="submit" value="Register">
              </form>';
    }
}
?>
