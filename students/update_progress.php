<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Replace with actual session value
    $courseName = mysqli_real_escape_string($conn, $_POST['course']);
    $topicName = mysqli_real_escape_string($conn, $_POST['topic']);
    $status = intval($_POST['status']); // 1 for checked, 0 for unchecked
    $uname = $_SESSION['uname'];

    // Fetch current progress
    $query = "
        SELECT topics_done, topics_done_count, topics_total_count 
        FROM user_progress 
        WHERE uname = '$uname' AND course_name = '$courseName'
    ";
    $result = mysqli_query($conn, $query);
    $progress = mysqli_fetch_assoc($result);

    $topicsDone = isset($progress['topics_done']) ? explode(',', $progress['topics_done']) : [];
    $topicsDoneCount = isset($progress['topics_done_count']) ? intval($progress['topics_done_count']) : 0;

    if ($status === 1 && !in_array($topicName, $topicsDone)) {
        // Add the topic to the list and increment count
        $topicsDone[] = $topicName;
        $topicsDoneCount++;
    } elseif ($status === 0 && in_array($topicName, $topicsDone)) {
        // Remove the topic from the list and decrement count
        $topicsDone = array_diff($topicsDone, [$topicName]);
        $topicsDoneCount--;
    }

    // Update the database
    $topicsDoneStr = implode(',', $topicsDone);
    $percentage = ($progress['topics_total_count'] > 0) 
        ? ($topicsDoneCount / $progress['topics_total_count']) * 100 
        : 0;

    $updateQuery = "
        UPDATE user_progress 
        SET topics_done = '$topicsDoneStr', 
            topics_done_count = $topicsDoneCount, 
            percentage_course = $percentage 
        WHERE uname = '$uname' AND course_name = '$courseName'
    ";
    mysqli_query($conn, $updateQuery);

    if (mysqli_error($conn)) {
        http_response_code(500);
        echo "Error updating progress: " . mysqli_error($conn);
    } else {
        echo "Progress updated successfully!";
    }
}
?>
