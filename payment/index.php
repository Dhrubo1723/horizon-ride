<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Passenger Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="toggle-container">
  <label class="switch">
    <input type="checkbox" id="darkModeToggle">
    <span class="slider round"></span>
  </label>
  <span class="toggle-label">Dark Mode</span>
</div>

<div class="app-container">
  <header>
    <h1><i class="fas fa-car-side"></i> RidePay</h1>
    <p><i class="fas fa-lock"></i> Secure Passenger Payment</p>
  </header>

  <main>
    <form id="paymentForm" action="process_payment.php" method="POST" class="payment-form">
      <label><i class="fas fa-user"></i> Passenger Name</label>
      <input type="text" name="name" placeholder="John Doe" required>

      <label><i class="fas fa-dollar-sign"></i> Amount</label>
      <input type="number" step="0.01" name="amount" placeholder="Enter amount" required>

      <label><i class="fas fa-credit-card"></i> Payment Method</label>
      <select name="method" required>
        <option value="">Select Method</option>
        <option value="Card">Credit/Debit Card</option>
        <option value="Cash">Cash</option>
        <option value="Wallet">Wallet</option>
      </select>

      <button type="submit"><i class="fas fa-paper-plane"></i> Pay Now</button>
    </form>
  </main>

  <footer>
    <p>© 2025 RideShare Inc.</p>
  </footer>
</div>

<script src="script.js"></script>
</body>
</html>
