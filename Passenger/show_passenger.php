<?php
require_once 'BasicPassenger.php';
require_once 'RideHistoryDecorator.php';
require_once 'VIPPassengerDecorator.php';

// Step 1: Create base passenger
$passenger = new BasicPassenger(101, "Noman");

// Step 2: Decorate with ride history
$rideHistory = ["Airport Ride", "Night Out"];
$passengerWithHistory = new RideHistoryDecorator($passenger, $rideHistory);

// Step 3: Further decorate with VIP privileges
$vipPassenger = new VIPPassengerDecorator($passengerWithHistory);

// Extract info (in real case, use proper getters or structured format)
$info = $vipPassenger->getDetails();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Passenger Profile</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      padding: 30px;
    }

    .profile-card {
      background: #fff;
      border-radius: 15px;
      max-width: 500px;
      margin: auto;
      padding: 25px 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .profile-card h2 {
      margin-top: 0;
      color: #2c3e50;
      font-size: 24px;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
    }

    .profile-detail {
      margin: 15px 0;
      line-height: 1.6;
      color: #34495e;
      font-size: 16px;
    }

    .tag {
      display: inline-block;
      background: #3498db;
      color: white;
      padding: 5px 10px;
      border-radius: 12px;
      font-size: 13px;
      margin: 3px;
    }
  </style>
</head>
<body>

  <div class="profile-card">
    <h2>👤 User Profile</h2>
    <div class="profile-detail">
      <?php
        // Extract details with regular expressions for cleaner display
        if (preg_match('/Passenger ID: (\d+), Name: ([^,]+), Ride History: \[(.*?)\], VIP Status: (.+)/', $info, $matches)) {
          echo "<strong>ID:</strong> {$matches[1]}<br>";
          echo "<strong>Name:</strong> {$matches[2]}<br>";
          echo "<strong>VIP Level:</strong> <span class='tag'>{$matches[4]}</span><br>";
          echo "<strong>Ride History:</strong><br>";

          $rides = explode(", ", $matches[3]);
          foreach ($rides as $ride) {
            echo "<span class='tag'>$ride</span> ";
          }
        } else {
          echo nl2br($info); // fallback
        }
      ?>
    </div>
  </div>

</body>
</html>
