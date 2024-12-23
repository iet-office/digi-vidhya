<?php 
// Debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../config.php');

// Debugging Database Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add Exam Details
if (isset($_POST["addexm"])) {
    $requiredFields = ['exname', 'nq', 'duration', 'desp', 'subt', 'extime'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            die("Missing field: $field");
        }
    }
    
    $exname = mysqli_real_escape_string($conn, $_POST["exname"]);
    $nq = mysqli_real_escape_string($conn, $_POST["nq"]);
    $duration = mysqli_real_escape_string($conn, $_POST["duration"]);
    $desp = mysqli_real_escape_string($conn, $_POST["desp"]);
    $subt = mysqli_real_escape_string($conn, $_POST["subt"]);
    $extime = mysqli_real_escape_string($conn, $_POST["extime"]);

    $sql = "INSERT INTO exm_list (exname, nq, desp, subt, extime, duration) 
            VALUES ('$exname', '$nq', '$desp', '$subt', '$extime', '$duration')";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        header("Location: exams.php");
        exit();
    } else {
        die("Error adding exam: " . mysqli_error($conn));
    }
}

// Add Questions to Database
if (isset($_POST["addqp"])) {
    $nq = mysqli_real_escape_string($conn, $_POST["nq"]);
    $exid = mysqli_real_escape_string($conn, $_POST["exid"]);

    for ($i = 1; $i <= $nq; $i++) {
        $q = mysqli_real_escape_string($conn, $_POST['q' . $i]);
        $o1 = mysqli_real_escape_string($conn, $_POST['o1' . $i]);
        $o2 = mysqli_real_escape_string($conn, $_POST['o2' . $i]);
        $o3 = mysqli_real_escape_string($conn, $_POST['o3' . $i]);
        $o4 = mysqli_real_escape_string($conn, $_POST['o4' . $i]);
        $a = mysqli_real_escape_string($conn, $_POST['a' . $i]);

        $sql = "INSERT INTO qstn_list (exid, qstn, qstn_o1, qstn_o2, qstn_o3, qstn_o4, qstn_ans, sno) 
                VALUES ('$exid', '$q', '$o1', '$o2', '$o3', '$o4', '$a', '$i')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Error adding question $i: " . mysqli_error($conn));
        }
    }

    header("Location: exams.php");
    exit();
}
?>
