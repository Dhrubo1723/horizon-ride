<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit();
}

echo "<h1>Welcome, " . $_SESSION['user'] . "!</h1>";
echo "<p>Your user type is: " . $_SESSION['user_type'] . "</p>";

if ($_SESSION['user_type'] == 'passenger') {
    echo "<h2>Login Successful!</h2>";
    //echo "<p>Ride Operations For Passengers.</p>";
    echo "<form action='ride_operations.php' method='GET'>
            <input type='submit' value='Next' class='btn btn-primary'>
          </form>";
} elseif ($_SESSION['user_type'] == 'driver') {
    echo "<h2>Login Successful!</h2>";
   // echo "<p>Driver Operations For Drivers.</p>";
    echo "<form action='driver_operations.php' method='GET'>
            <input type='submit' value='Next' class='btn btn-primary'>
          </form>";
}

?>

<p><a href="logout.php">Logout</a></p>
<link rel="stylesheet" href="../assets/style.css">
