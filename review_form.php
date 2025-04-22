<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Review.php';
require_once 'ReviewFacade.php';
$rider = new User(1, "Atik");
$driver = new User(2, "Ahmed");
$facade = new ReviewFacade($pdo);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = intval($_POST["rating"]);
    $comment = htmlspecialchars($_POST["comment"]);
    $reviewID = 0;
    $facade->submitReview($reviewID, $rating, $comment, $rider, $driver);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>RideShare - Submit Review</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f0f2f5;
      transition: background 0.4s;
    }
    .container {
      max-width: 480px;
      margin: 50px auto;
      background: white;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .container.dark {
      background: #1e1e2f;
      color: white;
    }
    .title {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    .input-group {
      margin-bottom: 1.5rem;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    input, textarea {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 12px;
      outline: none;
      transition: border 0.3s;
    }
    input:focus, textarea:focus {
      border-color: #007bff;
    }
    button {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      background: #007bff;
      border: none;
      border-radius: 12px;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #0056b3;
    }
    .toggle-dark {
      position: absolute;
      top: 1rem;
      right: 1rem;
      cursor: pointer;
      font-size: 1.2rem;
    }
    .card-confirm {
      margin-top: 1.5rem;
      padding: 1rem;
      border-radius: 12px;
      background: #d1e7dd;
      color: #0f5132;
      font-weight: 600;
    }
    .container.dark .card-confirm {
      background: #2d3a42;
      color: #b0f0dd;
    }
    a {
      display: inline-block;
      margin-top: 1.5rem;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container" id="app">
    <div class="toggle-dark" onclick="toggleDarkMode()" title="Toggle dark mode">
      <i class="fas fa-moon"></i>
    </div>

    <div class="title">
      <i class="fas fa-pen"></i> Submit Rider Review
    </div>

    <form method="POST" action="" onsubmit="return validateForm()">
      <div class="input-group">
        <label for="rating">Rating (1–5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required />
      </div>

      <div class="input-group">
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>
      </div>

      <button type="submit">
        <i class="fas fa-paper-plane"></i> Submit Review
      </button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
      <div class="card-confirm">
        <i class="fas fa-check-circle"></i> Review submitted successfully!
      </div>
    <?php endif; ?>

    <a href="index.php"><i class="fas fa-eye"></i> View All Reviews</a>
  </div>

  <script>
    function toggleDarkMode() {
      const app = document.getElementById('app');
      app.classList.toggle('dark');
    }

    function validateForm() {
      const rating = document.getElementById('rating').value;
      const comment = document.getElementById('comment').value;

      if (rating < 1 || rating > 5) {
        alert("Please enter a rating between 1 and 5.");
        return false;
      }

      if (comment.trim().length < 5) {
        alert("Please enter a meaningful comment.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
