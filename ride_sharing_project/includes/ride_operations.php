<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'passenger') {
    header("Location: login.php");  
    exit();
}

$rideMessage = ''; 
$rideCancelMessage = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['requestRide'])) {
        $pickup_point = $_POST['pickup_point'];
        $drop_point = $_POST['drop_point'];
        $fare = $_POST['fare'];
        $passenger_email = $_SESSION['user'];  
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO ride (passenger_email, pickup_point, drop_point, fare) 
                  VALUES ('$passenger_email', '$pickup_point', '$drop_point', '$fare')";
        if ($db->query($query)) {
            $ride_number = $db->insert_id;  
            $rideMessage = "Ride Request Successful! Ride Number: $ride_number <br> Pickup: $pickup_point <br> Drop: $drop_point <br> Fare: $$fare";
        } else {
            $rideMessage = "Error: Unable to request ride.";
        }

    } elseif (isset($_POST['cancelRide'])) {
        $ride_number = $_POST['ride_number'];
        $passenger_email = $_SESSION['user'];  

        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM ride WHERE ride_number='$ride_number' AND passenger_email='$passenger_email' AND status='pending'";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            $deleteQuery = "DELETE FROM ride WHERE ride_number='$ride_number' AND passenger_email='$passenger_email'";
            if ($db->query($deleteQuery)) {
                $rideCancelMessage = "Ride cancelled successfully!";
            } else {
                $rideCancelMessage = "Error: Unable to cancel the ride.";
            }
        } else {
            $rideCancelMessage = "No ride found with this ride number.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Operations</title>
    <link rel="stylesheet" href="../assets/style.css"> 
</head>
<body>

    <div class="container">
        <h1>Ride Operations</h1>

        <?php if ($rideMessage): ?>
            <div class="alert alert-success">
                <?php echo $rideMessage; ?>
            </div>
        <?php endif; ?>

        <?php if ($rideCancelMessage): ?>
            <!-- No CSS for the cancel message -->
            <div class="ride-cancel-message">
                <?php echo $rideCancelMessage; ?>
            </div>
        <?php endif; ?>

        <h2>Select an Option</h2>
        <form method="POST" action="ride_operations.php">
            <div class="radio-buttons">
                <input type="radio" name="operation" value="request" checked> Request Ride<br>
                <input type="radio" name="operation" value="cancel"> Cancel Ride<br>
            </div>
            <input type="submit" value="Proceed">
        </form>

        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'request'): ?>
            <div class="ride-operations-container">
                <h2>Request a Ride</h2>
                <form method="POST" action="ride_operations.php">
                    <input type="hidden" name="requestRide" value="1">
                    <div class="form-control">
                        <label for="pickup_point">Pickup Point:</label>
                        <input type="text" id="pickup_point" name="pickup_point" required>
                    </div>
                    <div class="form-control">
                        <label for="drop_point">Drop Point:</label>
                        <input type="text" id="drop_point" name="drop_point" required>
                    </div>
                    <div class="form-control">
                        <label for="fare">Fare:</label>
                        <input type="text" id="fare" name="fare" required>
                    </div>
                    <input type="submit" value="Request Ride">
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_POST['operation']) && $_POST['operation'] == 'cancel'): ?>
            <div class="ride-operations-container">
                <h2>Cancel a Ride</h2>
                <form method="POST" action="ride_operations.php">
                    <input type="hidden" name="cancelRide" value="1">
                    <div class="form-control">
                        <label for="ride_number">Enter Ride Number:</label>
                        <input type="text" id="ride_number" name="ride_number" required>
                    </div>
                    <input type="submit" value="Cancel Ride">
                </form>
            </div>
        <?php endif; ?>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>

</body>
</html>
