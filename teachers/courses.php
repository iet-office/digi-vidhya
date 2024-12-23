<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!isset($_SESSION["fname"])) {
  header("Location: ../login_teacher.php");
}
include '../config.php';
error_reporting(0);

$sql = "SELECT * FROM exm_list";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Messages</title>
  <link rel="stylesheet" href="css/dash.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bx-diamond'></i>
      <span class="logo_name">Welcome</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="dash.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>  
      <li>
        <a href="employee_search.php">
          <i class="bx bx-search"></i>
          <span class="links_name">Employees</span>
        </a>
      </li>
      <!-- courses section inserting -->
      <li>
        <a href="#" class="active">
          <i class='bx bxs-graduation'></i>
          <span class="links_name">Courses</span>
        </a>
      </li>
      <li>
        <a href="exams.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Exams</span>
        </a>
      </li>
      <li>
        <a href="results.php">
          <i class='bx bxs-bar-chart-alt-2'></i>
          <span class="links_name">Results</span>
        </a>
      </li>
      <li>
        <a href="records.php">
          <i class='bx bxs-user-circle'></i>
          <span class="links_name">Records</span>
        </a>
      </li>
      <li>
        <a href="messages.php">
          <i class='bx bx-message'></i>
          <span class="links_name">Messages</span>
        </a>
      </li>
      <li>
        <a href="settings.php">
          <i class='bx bx-cog'></i>
          <span class="links_name">Settings</span>
        </a>
      </li>
      <li>
        <a href="help.php">
          <i class='bx bx-help-circle'></i>
          <span class="links_name">Help</span>
        </a>
      </li>
      <li class="log_out">
        <a href="../logout.php">
          <i class='bx bx-log-out-circle'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Examiner's Dashboard</span>
      </div>
      <div class="profile-details">
        <img src="<?php echo $_SESSION['img']; ?>" alt="pro">
        <span class="admin_name"><?php echo $_SESSION['fname']; ?></span>
      </div>
    </nav>

    <!-- form box -->
    <div class="home-content" style="background-color:#45a089">
      <div class="stat-boxes">
        <div class="courses-section">
          <h2>Manage Courses</h2>
          <form method="POST" enctype="multipart/form-data">
            <!-- Course Selection -->
            <label for="course">Select a Course:</label>
            <select name="course_id" id="course" required>
              <option value="">-- Select Course --</option>
              <?php if (isset($result)) {
                while ($row = mysqli_fetch_assoc($result)): ?>
                  <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php endwhile;
              } else { ?>
                <option value="">No courses available</option>
              <?php } ?>
            </select>

            <!-- Topic Selection -->
            <label for="topic">Select a Topic:</label>
            <select name="topic_id" id="topic" required>
              <option value="">-- Select Topic --</option>
              <?php if (isset($topics_result)) {
                while ($topic_row = mysqli_fetch_assoc($topics_result)): ?>
                  <option value="<?php echo $topic_row['id']; ?>"><?php echo $topic_row['name']; ?></option>
                <?php endwhile;
              } else { ?>
                <option value="">No topics available</option>
              <?php } ?>
            </select>

            <!-- Subtopic Selection -->
            <label for="subtopic">Select a Subtopic:</label>
            <select name="subtopic_id" id="subtopic" required>
              <option value="">-- Select Subtopic --</option>
              <?php if (isset($subtopics_result)) {
                while ($subtopic_row = mysqli_fetch_assoc($subtopics_result)): ?>
                  <option value="<?php echo $subtopic_row['id']; ?>"><?php echo $subtopic_row['name']; ?></option>
                <?php endwhile;
              } else { ?>
                <option value="">No subtopics available</option>
              <?php } ?>
            </select>

            <!-- YouTube Embedded Link -->
            <label for="youtube_link">YouTube Embedded Link:</label>
            <input type="url" name="youtube_link" id="youtube_link" placeholder="Paste YouTube embed link here">

            <!-- Upload Video -->
            <label for="video">Upload Video:</label>
            <input type="file" name="video" id="video" accept="video/*">

            <!-- Description -->
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="10" placeholder="Enter description"></textarea>

            <!-- Submit -->
            <button type="submit" name="upload">Upload</button>
          </form>
        </div>
        <?php
        // Handle form submission
        if (isset($_POST['upload'])) {
          $course_id = $_POST['course_id'];
          $topic_id = $_POST['topic_id'];
          $subtopic_id = $_POST['subtopic_id'];
          $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
          $description = mysqli_real_escape_string($conn, $_POST['description']);

          // Handle file upload
          $video_name = $_FILES['video']['name'] ?? null;
          $video_tmp = $_FILES['video']['tmp_name'] ?? null;
          $video_path = $video_name ? 'uploads/videos/' . $video_name : null;

          if ($video_name && move_uploaded_file($video_tmp, $video_path)) {
            // Video uploaded successfully
          }

          // Insert data into database
          $sql_insert = "INSERT INTO subtopics (course_id, topic_id, subtopic_id, youtube_link, video_url, description) 
                   VALUES ('$course_id', '$topic_id', '$subtopic_id', '$youtube_link', '$video_path', '$description')";
          if (mysqli_query($conn, $sql_insert)) {
            echo "<p>Data uploaded successfully!</p>";
          } else {
            echo "<p>Error uploading data: " . mysqli_error($conn) . "</p>";
          }
        }
        ?>


      </div>
    </div>
  </section>
  <script src="../js/script.js"></script>

</body>

</html>

<style>
  .courses-section {
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    max-width: 600px;
    margin: auto;
    margin-bottom: 20px;
    width: 100%;
  }

  .courses-section h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .courses-section form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .courses-section form label {
    font-weight: bold;
  }

  .courses-section form input,
  .courses-section form select,
  .courses-section form textarea,
  .courses-section form button {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .courses-section form button {
    background: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
  }

  .courses-section form button:hover {
    background: #45a049;
  }
</style>