<?php
require_once 'User.php';

class Passenger extends User {
    private $paymentMethod;

    public function __construct($name, $email, $phone_number, $password, $paymentMethod) {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->type = 'passenger';
        $this->paymentMethod = $paymentMethod;
    }

    public function saveAdditionalInfo($userID) {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO passengers (passengerID, paymentMethod) 
                  VALUES ('$userID', '$this->paymentMethod')";
        $db->query($query);
    }

    public function displayForm() {
        echo '<form method="POST">
                <label>Payment Method: <input type="text" name="paymentMethod" required></label><br>
                <input type="submit" value="Register">
              </form>';
    }
}
?>
