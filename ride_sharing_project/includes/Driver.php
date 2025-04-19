<?php
require_once 'User.php';
class Driver extends User {
    private $licenseNumber;
    private $vehicle;
    private $availability;

    public function __construct($name, $email, $phone_number, $password, $licenseNumber, $vehicle, $availability) {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->type = 'driver';
        $this->licenseNumber = $licenseNumber;
        $this->vehicle = $vehicle;
        $this->availability = $availability;
    }

    public function saveAdditionalInfo($userID) {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO drivers (driverID, licenseNumber, vehicle, availability) 
                  VALUES ('$userID', '$this->licenseNumber', '$this->vehicle', '$this->availability')";
        $db->query($query);
    }

    public function displayForm() {
        echo '<form method="POST">
                <label>License Number: <input type="text" name="licenseNumber" required></label><br>
                <label>Vehicle: <input type="text" name="vehicle" required></label><br>
                <label>Availability: <input type="checkbox" name="availability" value="1"></label><br>
                <input type="submit" value="Register">
              </form>';
    }
}
?>
