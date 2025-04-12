<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>User Registration</h2>

<form action="../register_process.php" method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Type: 
    <select name="type">
        <option value="passenger">Passenger</option>
        <option value="driver">Driver</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <button type="submit">Register</button>
</form>
