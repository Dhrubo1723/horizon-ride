<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Review.php';
require_once 'ReviewFacade.php';
$facade = new ReviewFacade($pdo);
$reviews = (new ReflectionClass($facade))->getMethod('showReviews')->invoke($facade, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>RideShare - All Reviews</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f9f9f9;
      transition: background 0.4s, color 0.4s; }
    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 2rem;
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      position: relative; }
    .container.dark {
      background: #1e1e2f;
      color: #fff; }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;  }
    .title {
      font-size: 1.8rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      gap: 10px;  }
    .toggle-dark {
      cursor: pointer;
      font-size: 1.3rem;   }
    .card {
      border-radius: 15px;
      background: #f1f3f6;
      padding: 1.2rem;
      margin-bottom: 1rem;
      transition: transform 0.3s, background 0.3s;
    }
    .container.dark .card {
      background: #2d2e3e;  }
    .card:hover {
      transform: translateY(-5px);  }
    .card h3 {
      margin: 0 0 0.4rem 0;
      font-size: 1.1rem;  }
    .card p {
      margin: 0.2rem 0;
      font-size: 0.95rem;
      line-height: 1.4
