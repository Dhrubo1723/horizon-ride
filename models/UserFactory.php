<?php
require_once __DIR__ . '/User.php';  // make sure this path is correct

class UserFactory {
    public static function createUser($type, $name, $email, $password) {
        switch (strtolower($type)) {
            case 'passenger':
                return new Passenger($name, $email, $password);
            case 'driver':
                return new Driver($name, $email, $password);
            case 'admin':
                return new Admin($name, $email, $password);
            default:
                throw new Exception("Invalid user type");
        }
    }
}

