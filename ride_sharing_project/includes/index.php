<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");  
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'];
} else {
    $userType = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Sharing System</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

    <div class="container">
        <h1>Welcome to the HorizonRide</h1>

        <?php if ($userType == ''): ?>
            <p>Please select user type:</p>
            <form method="POST" action="index.php">
                <label>User Type:
                    <select name="userType" required>
                        <option value="driver">Driver</option>
                        <option value="passenger">Passenger</option>
                        <option value="admin">Admin</option>
                    </select>
                </label><br><br>

                <input type="submit" value="Register">
            </form>
        <?php else: ?>
            <h2><?php echo ucfirst($userType); ?> Registration</h2>

            <form method="POST" action="register.php">
                <input type="hidden" name="userType" value="<?php echo $userType; ?>">

                <label>Name: <input type="text" name="name" required></label><br>
                <label>Email: <input type="email" name="email" required></label><br>
                <label>Phone Number: <input type="text" name="phone_number" required></label><br>
                <label>Password: <input type="password" name="password" required></label><br>

                
                <?php if ($userType == 'driver'): ?>
                    <label>License Number: <input type="text" name="licenseNumber" required></label><br>
                    <label>Vehicle: <input type="text" name="vehicle" required></label><br>
                <?php elseif ($userType == 'passenger'): ?>
                    <label>Payment Method: <input type="text" name="paymentMethod" required></label><br>
                <?php elseif ($userType == 'admin'): ?>
                    <p>Admins have special privileges.</p>
                <?php endif; ?>

                <input type="submit" value="Register">
            </form>
        <?php endif; ?>
        
        <hr>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>
