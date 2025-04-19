<?php
require_once 'Database.php';
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $userType = $_POST['userType'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $db = Database::getInstance()->getConnection();

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email); // Bind email as string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Email already exists. Please choose a different email.";
    } else {
        // Insert into users table using prepared statement (common fields for all users)
        $query = "INSERT INTO users (name, email, phone_number, password, type) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssss", $name, $email, $phone_number, $hashedPassword, $userType);

        if ($stmt->execute()) {
            $userID = $stmt->insert_id;  // Get the last inserted user ID

            // Insert user-specific details into the relevant table
            if ($userType == 'driver') {
                // Driver-specific fields
                $licenseNumber = $_POST['licenseNumber'];
                $vehicle = $_POST['vehicle'];
                $availability = isset($_POST['availability']) ? 1 : 0; // Availability from checkbox

                // Insert driver-specific information into the drivers table
                $driverQuery = "INSERT INTO drivers (driverID, name, email, phone_number, password, licenseNumber, vehicle, availability) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $db->prepare($driverQuery);
                $stmt->bind_param("issssssi", $userID, $name, $email, $phone_number, $hashedPassword, $licenseNumber, $vehicle, $availability);
                $stmt->execute();
            } elseif ($userType == 'passenger') {
                // Passenger-specific fields
                $paymentMethod = $_POST['paymentMethod'];

                // Insert passenger-specific information into the passengers table
                $passengerQuery = "INSERT INTO passengers (passengerID, name, email, phone_number, password, paymentMethod) 
                                   VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $db->prepare($passengerQuery);
                $stmt->bind_param("isssss", $userID, $name, $email, $phone_number, $hashedPassword, $paymentMethod);
                $stmt->execute();
            } elseif ($userType == 'admin') {
                // Admin-specific fields (if any)
                // In this case, we just insert the userID into the admins table
                $adminQuery = "INSERT INTO admins (adminID) VALUES (?)";
                $stmt = $db->prepare($adminQuery);
                $stmt->bind_param("i", $userID);
                $stmt->execute();
            }

            // Redirect to login page after successful registration
            header("Location: login.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!-- Registration Form -->
<form method="POST" action="register.php">
    <label>Name: <input type="text" name="name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Phone Number: <input type="text" name="phone_number" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <label>User Type:
        <select name="userType" required>
            <option value="driver">Driver</option>
            <option value="passenger">Passenger</option>
            <option value="admin">Admin</option>
        </select>
    </label><br>

    <!-- Driver-specific fields -->
    <div id="driverFields" style="display: none;">
        <label>License Number: <input type="text" name="licenseNumber" required></label><br>
        <label>Vehicle: <input type="text" name="vehicle" required></label><br>
        <label>Availability: <input type="checkbox" name="availability"> Available</label><br>
    </div>

    <!-- Passenger-specific fields -->
    <div id="passengerFields" style="display: none;">
        <label>Payment Method: <input type="text" name="paymentMethod" required></label><br>
    </div>

    <input type="submit" value="Register">
</form>

<!-- JavaScript to show/hide fields based on user type -->
<script>
    document.querySelector('select[name="userType"]').addEventListener('change', function () {
        var userType = this.value;
        document.getElementById('driverFields').style.display = (userType === 'driver') ? 'block' : 'none';
        document.getElementById('passengerFields').style.display = (userType === 'passenger') ? 'block' : 'none';
    });
</script>
