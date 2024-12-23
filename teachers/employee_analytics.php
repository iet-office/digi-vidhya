<?php
session_start();
include '../config.php';

if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

// Get all skills from the database
$sql = "SELECT `Programming skills` AS skills FROM employee_details";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit();
}

$skills_counts = [];
while ($row = $result->fetch_assoc()) {
    // Normalize delimiters and split skills
    $skills = preg_split('/[;,]/', $row['skills']);
    foreach ($skills as $skill) {
        $skill = trim($skill); // Trim whitespace
        if (!empty($skill)) { 
            if (isset($skills_counts[$skill])) {
                $skills_counts[$skill]++;
            } else {
                $skills_counts[$skill] = 1;
            }
        }
    }
}

// Prepare the result for JSON output
$skills_data = [];
foreach ($skills_counts as $skill => $count) {
    if ($count > 1)
        $skills_data[] = [
            'skill' => $skill,
            'count' => $count
        ];
}

// Return the data as JSON
echo json_encode($skills_data);
