<?php
require_once 'Driver.php';
require_once 'Passenger.php';
require_once 'Admin.php';

class UserFactory {
    public static function createUser($type, $name, $email, $phone_number, $password, $additionalFields = []) {
        // Create a map of user types to their respective classes
        $userMap = [
            'driver' => function() use ($name, $email, $phone_number, $password, $additionalFields) {
                return new Driver($name, $email, $phone_number, $password, $additionalFields['licenseNumber'], $additionalFields['vehicle'], $additionalFields['availability']);
            },
            'passenger' => function() use ($name, $email, $phone_number, $password, $additionalFields) {
                return new Passenger($name, $email, $phone_number, $password, $additionalFields['paymentMethod']);
            },
            'admin' => function() use ($name, $email, $phone_number, $password) {
                return new Admin($name, $email, $phone_number, $password);
            }
        ];

        // Check if the user type exists in the map, and create the user
        if (isset($userMap[$type])) {
            return $userMap[$type]();  // Execute the closure to create the user
        }

        // If the type is not found, throw an exception
        throw new Exception("Invalid user type");
    }
}
