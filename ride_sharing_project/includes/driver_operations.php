<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'driver') {
    header("Location: login.php");  
    exit();
}

$operationMessage = '';  
$rideOptions = []; 
$driver_email = $_SESSION['user'];  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkAvailability'])) {
        
        $availability = $_POST['availability'];  

        $db = Database::getInstance()->getConnection();
        $query = "UPDATE drivers SET availability='$availability' WHERE email='$driver_email'";  // Changed driver_email to email

        if ($db->query($query)) {
            $operationMessage = "Availability updated successfully to $availability!";
        } else {
            $operationMessage = "Error: Unable to update availability.";
        }

    } elseif (isset($_POST['acceptRide'])) {
        $ride_number = $_POST['ride_number'];

        $db = Database::getInstance()->getConnection();

        $query = "SELECT * FROM ride WHERE ride_number='$ride_number' AND status='pending'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            $ride = $result->fetch_assoc();
            $pickup = $ride['pickup_point'];
            $drop = $ride['drop_point'];
            $fare = $ride['fare'];
            $passenger_email = $ride['passenger_email'];  

            $acceptQuery = "UPDATE ride SET status='accepted' WHERE ride_number='$ride_number'";
            if ($db->query($acceptQuery)) {
                $query_check_driver = "SELECT * FROM drivers WHERE email='$driver_email'";  // Changed driver_email to email
                $check_driver_result = $db->query($query_check_driver);

                if ($check_driver_result->num_rows > 0) {
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
        $ride_number = $_POST['ride_number'];
        $db = Database::getInstance()->getConnection();

        $query = "SELECT * FROM ride WHERE ride_number='$ride_number' AND status='pending'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
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

if (isset($_POST['operation']) && $_POST['operation'] == 'acceptRide') {
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM ride WHERE status='pending'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        while ($ride = $result->fetch_assoc()) {
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

        <?php if ($operationMessage): ?>
            <div class="alert alert-success">
                <?php echo $operationMessage; ?>
            </div>
        <?php endif; ?>
        <h2>Select an Option</h2>
        <form method="POST" action="driver_operations.php">
            <input type="radio" name="operation" value="checkAvailability" checked> Check Availability<br>
            <input type="radio" name="operation" value="acceptRide"> Accept Ride<br>
            <input type="radio" name="operation" value="rejectRide"> Reject Ride<br><br>
            <input type="submit" value="Proceed">
        </form>
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
        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'acceptRide'): ?>
            <h2>Accept a Ride</h2>
            <form method="POST" action="driver_operations.php">
                <input type="hidden" name="acceptRide" value="1">
                <label>Choose Ride to Accept:</label><br>
                <select name="ride_number" required>
                    <option value="">-- Select Ride --</option>
                    <?php
                    foreach ($rideOptions as $ride) {
                        echo "<option value='" . $ride['ride_number'] . "'>Ride Number: " . $ride['ride_number'] . " - Pickup: " . $ride['pickup_point'] . " - Drop: " . $ride['drop_point'] . " - Fare: $" . $ride['fare'] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="submit" value="Accept Ride">
            </form>
        <?php endif; ?>
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
