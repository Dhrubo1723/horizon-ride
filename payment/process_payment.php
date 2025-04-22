<?php
require_once 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$name = $_POST['name'] ?? '';
$amount = $_POST['amount'] ?? '';
$method = $_POST['method'] ?? '';
$date = date("Y-m-d H:i:s");

$sql = "INSERT INTO payments (passenger_name, amount, payment_method, transaction_date)
        VALUES ('$name', '$amount', '$method', '$date')";

?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Result</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="app-container">
  <header>
    <h2><i class="fas fa-check-circle"></i> Payment Status</h2>
  </header>

  <main style="text-align:center; padding:30px;">
    <?php if ($conn->query($sql) === TRUE): ?>
      <div style="background:#dff0d8; padding:20px; border-radius:12px;">
        <h3>✅ Payment Successful!</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Amount:</strong> $<?= htmlspecialchars($amount) ?></p>
        <p><strong>Method:</strong> <?= htmlspecialchars($method) ?></p>
        <a href="index.php"><button style="margin-top:20px;">Make Another Payment</button></a>
      </div>
    <?php else: ?>
      <div style="background:#f2dede; padding:20px; border-radius:12px;">
        <h3>❌ Payment Failed</h3>
        <p><?= $conn->error ?></p>
        <a href="index.php"><button style="margin-top:20px;">Try Again</button></a>
      </div>
    <?php endif; ?>
  </main>
</div>

</body>
</html>
