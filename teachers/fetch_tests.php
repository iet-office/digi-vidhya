<?php
include '../config.php'; // Ensure this includes the database connection setup

// Fetch test names from the 'exam_list' table
$sql = "SELECT exname FROM exm_list";
$result = mysqli_query($conn, $sql);

$tests = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tests[] = $row['exname'];
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($tests);
