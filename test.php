<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include your config file here

// Test database connection and fetch data
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Username: " . htmlspecialchars($row['uname']) . "<br>";
            echo "First Name: " . htmlspecialchars($row['fname']) . "<br>";
            echo "Email: " . htmlspecialchars($row['email']) . "<br>";
            // Add more fields as needed
        }
    } else {
        echo "No records found.";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}
?>
