<?php
require_once __DIR__ . '/controllers/UserController.php';

session_start();
echo '<link rel="stylesheet" href="css/style.css">';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $controller = new UserController();
    $loginResult = $controller->login($email, $password);

    if ($loginResult['success']) {
        // Save user info in session
        $_SESSION['user'] = $loginResult['user'];
        echo "✅ Login successful! Welcome, " . $loginResult['user']['name'];

        // Optionally redirect
        // header('Location: dashboard.php'); exit;
    } else {
        echo "❌ Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Result</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="<?= $class ?>">
    <?= $message ?>
</div>

<div style="text-align:center;">
    <a href="views/login.php">
        <button>⬅ Back to Login</button>
    </a>
</div>

</body>
</html>










