<?php
require_once 'config/Database.php'; // Include Singleton class

// Get the one and only Database instance
$db = Database::getInstance();

// Get the connection object
$conn = $db->getConnection();

// Let’s test with a query (assuming you have a `users` table)
$result = $conn->query("SELECT * FROM users");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "User: " . $row['name'] . "<br>";
    }
} else {
    echo "Query failed!";
}
?>
