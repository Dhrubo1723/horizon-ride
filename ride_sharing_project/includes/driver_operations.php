<?php
session_start();
require_once 'Database.php';

// Check if the user is logged in as a driver
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'driver') {
    header("Location: login.php");  // If not logged in as driver, redirect to login page
    exit();
}

$operationMessage = '';  // Initialize message for success or error
$rideOptions = []; // Initialize an array to hold ride options
$driver_email = $_SESSION['user'];  // Get the logged-in driver's email from the session

// Handle form submission for operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkAvailability'])) {
        // Check Availability Logic
        $availability = $_POST['availability'];  // availability can be 'available', 'busy', or 'offline'

        // Database connection
        $db = Database::getInstance()->getConnection();

        // Update driver availability in the database
        $query = "UPDATE drivers SET availability='$availability' WHERE email='$driver_email'";  // Changed driver_email to email

        if ($db->query($query)) {
            $operationMessage = "Availability updated successfully to $availability!";
        } else {
            $operationMessage = "Error: Unable to update availability.";
        }

    } elseif (isset($_POST['acceptRide'])) {
        // Accept Ride Logic
        $ride_number = $_POST['ride_number'];

        // Database connection
        $db = Database::getInstance()->getConnection();

        // Get ride details from the database
        $query = "SELECT * FROM ride WHERE ride_number='$ride_number' AND status='pending'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            // Ride exists, proceed to accept it
            $ride = $result->fetch_assoc();
            // Show the passenger's details
            $pickup = $ride['pickup_point'];
            $drop = $ride['drop_point'];
            $fare = $ride['fare'];
            $passenger_email = $ride['passenger_email'];  // Assuming passenger_email is in the `ride` table

            // Update the ride status to accepted
            $acceptQuery = "UPDATE ride SET status='accepted' WHERE ride_number='$ride_number'";
            if ($db->query($acceptQuery)) {
                // Check if the driver exists in the database using email
                $query_check_driver = "SELECT * FROM drivers WHERE email='$driver_email'";  // Changed driver_email to email
                $check_driver_result = $db->query($query_check_driver);

                if ($check_driver_result->num_rows > 0) {
                    // Driver exists, insert into the acceptance table
                    $acceptanceQuery = "INSERT INTO acceptance (ride_number, driver_email, passenger_email, acceptance_status)
                                        VALUES ('$ride_number', '$driver_email', '$passenger_email', 'accepted')";
                    
                    if ($db->query($acceptanceQuery)) {
                        $operationMessage = "Ride accepted successfully! <br> Ride Number: $ride_number <br> Pickup: $pickup <br> Drop: $drop <br> Fare: $$fare";
                    } else {
                        $operationMessage = "Error: Unable to record acceptance.";
                    }
                } else {
                    $operationMessage = "Error: Driver email does not exist in the database.";
                }
            } else {
                $operationMessage = "Error: Unable to accept the ride.";
            }
        } else {
            $operationMessage = "No pending ride found with this ride number.";
        }

    } elseif (isset($_POST['rejectRide'])) {
        // Reject Ride Logic
        $ride_number = $_POST['ride_number'];

        // Database connection
        $db = Database::getInstance()->getConnection();

        // Check if the ride exists and is still pending
        $query = "SELECT * FROM ride WHERE ride_number='$ride_number' AND status='pending'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            // Ride exists, proceed to reject it
            $rejectQuery = "UPDATE ride SET status='rejected' WHERE ride_number='$ride_number'";
            if ($db->query($rejectQuery)) {
                $operationMessage = "Ride cancelled successfully! <br> Ride Number: $ride_number";
            } else {
                $operationMessage = "Error: Unable to reject the ride.";
            }
        } else {
            $operationMessage = "No pending ride found with this ride number.";
        }
    }
}

// Fetch all pending rides for the driver to choose from
if (isset($_POST['operation']) && $_POST['operation'] == 'acceptRide') {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM ride WHERE status='pending'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        while ($ride = $result->fetch_assoc()) {
            // Store the ride details for the dropdown options
            $rideOptions[] = $ride;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Operations</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Link to your custom CSS -->
</head>
<body>

    <div class="container">
        <h1>Driver Operations</h1>

        <!-- Display message -->
        <?php if ($operationMessage): ?>
            <div class="alert alert-success">
                <?php echo $operationMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Show options for the driver -->
        <h2>Select an Option</h2>
        <form method="POST" action="driver_operations.php">
            <input type="radio" name="operation" value="checkAvailability" checked> Check Availability<br>
            <input type="radio" name="operation" value="acceptRide"> Accept Ride<br>
            <input type="radio" name="operation" value="rejectRide"> Reject Ride<br><br>
            <input type="submit" value="Proceed">
        </form>

        <!-- Handle Check Availability -->
        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'checkAvailability'): ?>
            <h2>Set Your Availability</h2>
            <form method="POST" action="driver_operations.php">
                <input type="hidden" name="checkAvailability" value="1">
                <label>Select Availability:</label><br>
                <select name="availability">
                    <option value="available">Available</option>
                    <option value="busy">Busy</option>
                    <option value="offline">Offline</option>
                </select><br>
                <input type="submit" value="Update Availability">
            </form>
        <?php endif; ?>

        <!-- Handle Accept Ride -->
        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'acceptRide'): ?>
            <h2>Accept a Ride</h2>
            <form method="POST" action="driver_operations.php">
                <input type="hidden" name="acceptRide" value="1">
                <label>Choose Ride to Accept:</label><br>
                <select name="ride_number" required>
                    <option value="">-- Select Ride --</option>
                    <?php
                    // Display the available pending rides from the database
                    foreach ($rideOptions as $ride) {
                        echo "<option value='" . $ride['ride_number'] . "'>Ride Number: " . $ride['ride_number'] . " - Pickup: " . $ride['pickup_point'] . " - Drop: " . $ride['drop_point'] . " - Fare: $" . $ride['fare'] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="submit" value="Accept Ride">
            </form>
        <?php endif; ?>

        <!-- Handle Reject Ride -->
        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'rejectRide'): ?>
            <h2>Reject a Ride</h2>
            <form method="POST" action="driver_operations.php">
                <input type="hidden" name="rejectRide" value="1">
                <label>Enter Ride Number: <input type="text" name="ride_number" required></label><br>
                <input type="submit" value="Reject Ride">
            </form>
        <?php endif; ?>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>

</body>
</html>
