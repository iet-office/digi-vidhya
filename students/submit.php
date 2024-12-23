<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the configuration file
include '../config.php';

// Validate session and POST data
if (!isset($_POST["exid"])) {
    die("Error: 'exid' is missing in POST request.");
}
if (!isset($_POST["nq"])) {
    die("Error: 'nq' (number of questions) is missing in POST request.");
}
if (!isset($_SESSION["uname"])) {
    die("Error: 'uname' (username) is missing in the session.");
}

// Escape inputs to prevent SQL injection
$nq = mysqli_real_escape_string($conn, $_POST["nq"]);
$exid = mysqli_real_escape_string($conn, $_POST["exid"]);
$uname = mysqli_real_escape_string($conn, $_SESSION["uname"]);

// Debug log for validation
error_log("Debug: exid=$exid, nq=$nq, uname=$uname");

try {
    $j = 0; // Counter for correct answers

    // Debug point
    error_log("Debug: Starting to process questions for exid $exid and uname $uname.");

    for ($i = 1; $i <= $nq; $i++) {
        // Check if the current question and selected option are set
        if (isset($_POST['qid' . $i]) && isset($_POST['o' . $i])) {
            $qid = mysqli_real_escape_string($conn, $_POST['qid' . $i]);
            $op = mysqli_real_escape_string($conn, $_POST['o' . $i]);

            // Fetch the correct answer
            $stmt = $conn->prepare("SELECT qstn_ans FROM qstn_list WHERE exid = ? AND qid = ?");
            if (!$stmt) {
                error_log("SQL Prepare Error: " . $conn->error);
                die("Error in preparing SQL query.");
            }
            $stmt->bind_param("si", $exid, $qid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['qstn_ans'] === $op) {
                    $j++; // Increment correct answer count
                }
            } else {
                error_log("No result found for exid=$exid and qid=$qid.");
            }
        } else {
            error_log("Missing input for question $i.");
        }
    }

    $ptg = ($j / $nq) * 100; // Calculate percentage
    $st = 1; // Status
    $certificate_id = uniqid(); // Generate a unique certificate ID

    // Insert attempt into the database
    if ($ptg > 60) {
        $stmt = $conn->prepare("INSERT INTO atmpt_list (exid, uname, nq, cnq, ptg, status, certificate_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiidis", $exid, $uname, $nq, $j, $ptg, $st, $certificate_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO atmpt_list (exid, uname, nq, cnq, ptg, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiidi", $exid, $uname, $nq, $j, $ptg, $st);
    }

    if ($stmt->execute()) {
        error_log("Debug: Successfully inserted results for uname=$uname.");
        header("Location: results.php");
        exit;
    } else {
        throw new Exception("Database insertion error: " . $stmt->error);
    }
} catch (Exception $e) {
    // Log and display the error
    error_log("Error in submit.php: " . $e->getMessage());
    echo "An error occurred while processing your request. Error details: " . $e->getMessage();
} finally {
    // Close the database connection
    $conn->close();
}
?>
