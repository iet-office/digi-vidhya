<?php
// Set the timezone

date_default_timezone_set('Asia/Kolkata');

// Database configuration
// $hostname = "digividya-dev-server.mysql.database.azure.com"; // Replace with your MySQL server hostname
// $username = "zdfvnoxooe"; // Replace with your MySQL username
// $password = "A12345678@"; // Replace with your MySQL password
// $database = "digividya-dev-database"; // Replace with your database name

// $conn = mysqli_init();

// mysqli_ssl_set($conn, NULL, NULL, __DIR__ . "/cert/DigiCertGlobalRootG2.crt.pem", NULL, NULL);

// mysqli_real_connect($conn, $hostname, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

// //If connection failed, show the error
// if (mysqli_connect_errno())
// {
//     die('Failed to connect to MySQL: '.mysqli_connect_error());
// }

// $sql_script = file_get_contents( __DIR__ ."/db/db_eval.sql");

// if (mysqli_multi_query($conn, $sql_script)) {
//     do {
//         // Clear results if there are multiple queries
//         if ($result = mysqli_store_result($conn)) {
//             mysqli_free_result($result);
//         }
//     } while (mysqli_next_result($conn));
// } else {
//     echo "Error creating tables: " . mysqli_error($conn);
// }

$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_eval";
 
$conn = mysqli_connect($hostname, $username, $password, $database);

// Time-based greeting logic
$time = date("H");
$timezone = date("e"); // Set the $timezone variable to become the current timezone

/* Greet based on the current time */
if ($time < "12") {
    $greet = "Good Morning";
    $img = "img/mng.jpg";
} else if ($time >= "12" && $time < "17") {
    $greet = "Good Afternoon";
    $img = "img/aftn.jpg";
} else if ($time >= "17" && $time < "19") {
    $greet = "Good Evening";
    $img = "img/evng.jpg";
} else {
    $greet = "Good Evening";
    $img = "img/evng.jpg";
}
?>
