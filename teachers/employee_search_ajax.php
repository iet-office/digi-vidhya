<?php
session_start();
include '../config.php';

if (!isset($_SESSION["user_id"])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

// Initialize response structure
$response = [
    "employees" => [],
    "filtered_count" => 0,
    "total_count" => 0
];

// Check if query exists
if (isset($_GET['query'])) {
    $search_term = "%" . $_GET['query'] . "%";

    // Get filtered count
    $filtered_count_query = "
        SELECT COUNT(*) as filtered_count
        FROM employee_details
        WHERE `Full name` LIKE ? OR `Programming skills` LIKE ?
    ";
    $stmt = $conn->prepare($filtered_count_query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "SQL Error: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    $response['filtered_count'] = $result->fetch_assoc()['filtered_count'];

    // Get total count
    $total_count_query = "SELECT COUNT(*) as total_count FROM employee_details";
    $result = $conn->query($total_count_query);
    $response['total_count'] = $result->fetch_assoc()['total_count'];

    // Fetch matching employees
    $employees_query = "
        SELECT 
            EMPID, `Full name` AS name, `Mail ID (Ielektron)` AS email, 
            `Programming skills` AS skills 
        FROM employee_details
        WHERE `Full name` LIKE ? OR `Programming skills` LIKE ?
    ";
    $stmt = $conn->prepare($employees_query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "SQL Error: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response['employees'][] = $row;
    }

    echo json_encode($response);
    exit();
} else {
    // No query provided
    $response['total_count'] = $conn->query("SELECT COUNT(*) FROM employee_details")->fetch_assoc()['COUNT(*)'];
    echo json_encode($response);
    exit();
}
?>
