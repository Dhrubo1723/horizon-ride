
<?php
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/models/UserFactory.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? 'passenger';

    try {
        $user = UserFactory::createUser($type, $_POST['name'], $_POST['email'], $_POST['password']);
        $controller = new UserController();

        if ($controller->register($user, $type)) {
            $message = "✅ Registered as $type successfully!";
            $class = "success";
        } else {
            $message = "❌ Registration failed. Email might already exist.";
            $class = "error";
        }
    } catch (Exception $e) {
        $message = "⚠️ Error: " . $e->getMessage();
        $class = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Result</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="<?= $class ?>">
    <?= $message ?>
</div>

<div style="text-align:center;">
    <a href="views/register.php">
        <button>⬅ Back to Registration</button>
    </a>
</div>

</body>
</html>
