<?php
require_once 'Database.php';
session_start();

$loginMessage = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $db = Database::getInstance()->getConnection();
    $query = "SELECT * FROM users WHERE email='$email'";

    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email']; 
            $_SESSION['user_type'] = $user['type']; 
            header("Location: dashboard.php");
            exit();
        } else {
            $loginMessage = "Invalid password!";
        }
    } else {
        $loginMessage = "No user found with that email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../assets/style.css"> 
</head>
<body class="login-page">

<div class="container">
    <h1 class="text-center mt-5">Login to HorizonRide</h1>

    <?php if ($loginMessage): ?>
        <div class="alert alert-danger text-center"><?php echo $loginMessage; ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3">Don't have an account? <a href="index.php">Register here</a></p>
</div>

</body>
</html>
