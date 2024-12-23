<?php
session_start();
if (!isset($_SESSION["uname"])) {
  header("Location: ../login_student.php");
  exit();
}

include '../config.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Courses</title>
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
        <a href="exams.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Exams</span>
        </a>
      </li>
      <!-- courses list updated here -->
      <li>
        <a href="courses.php" class="active">
          <i class='bx bxs-graduation'></i>
          <span class="links_name">Courses</span>
        </a>
      </li>
      <li>
        <a href="results.php">
          <i class='bx bxs-bar-chart-alt-2'></i>
          <span class="links_name">Results</span>
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
      <li>
        <a href="help copy.php">
          <i class='bx bx-book'></i>
          <span class="links_name">Documentation</span>
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
        <span class="dashboard">Employee Dashboard</span>
      </div>
      <div class="profile-details">
        <img src="<?php echo $_SESSION['img']; ?>" alt="pro">
        <span class="admin_name"><?php echo $_SESSION['fname']; ?></span>
      </div>
    </nav>

    <div class="home-content">
      <div class="stat-boxes">
        <div class="recent-stat box" style="padding: 20px; width:100%;">
          <?php
          $course_topics = [
            'Python' => [
              'Data Types' => [],
              'Loops' => [],
              'OOP Concepts' => [],
            ],

            'DevOps' => [
              'Fundamentals' => [],
              'Linux' => [],
            ],
            'Data Enginner' => [
              'Key Components' => [],
            ],
          ];

          if (isset($_GET['course'])):
            $course_name = htmlspecialchars(string: $_GET['course']);
          ?>
            <!-- Display course topics -->
            <h1><?php echo $course_name; ?> Topics</h1>
            <div class="topic-container">
              <?php if (isset($course_topics[$course_name])): ?>
                <?php foreach ($course_topics[$course_name] as $topic => $details): ?>
                  <div class="topic">
                    <h2>
                      <a href="topic.php?course=<?php echo urlencode($course_name); ?>&topic=<?php echo urlencode($topic); ?>">
                        <?php echo $topic; ?>
                      </a>
                    </h2>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>No topics available for this course.</p>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <!-- Default view with course list -->
            <h1>Explore Courses</h1>
            <div class="course-cards">
              <?php foreach (array_keys($course_topics) as $course): ?>
                <?php

                // Check and insert default entry if it doesn't exist
                $userId = $_SESSION['user_id']; // Replace with actual session user ID
                $uname = $_SESSION['uname']; 
                $courseNameEscaped = mysqli_real_escape_string($conn, $course);

                // Query to check if the course entry exists for the user
                $query = "
        SELECT topics_done_count, topics_total_count 
        FROM user_progress
        WHERE uname = '$uname' AND course_name = '$courseNameEscaped'
    ";
                $result = mysqli_query($conn, $query);

                $progress = mysqli_fetch_assoc($result);

                

                if (!$progress) {
                  // Insert default entry if none exists
                  $topicsTotalCount = count($course_topics[$course]);
                  $insertQuery = "
            INSERT INTO user_progress (uname, course_name, topics_done, topics_done_count, topics_total_count, percentage_course)
            VALUES ('$uname', '$courseNameEscaped', '', 0, $topicsTotalCount, 0.0)
        ";
                  // mysqli_query($conn, $insertQuery);

                  if (!mysqli_query($conn, $insertQuery)) {
                    die("Insert Failed: " . mysqli_error($conn));
                }

                  // Set default progress
                  $progress = [
                    'topics_done_count' => 0,
                    'topics_total_count' => $topicsTotalCount,
                  ];
                }

                // Calculate progress message
                $completed = $progress['topics_done_count'];
                $total = $progress['topics_total_count'];
                $progressMessage = ($completed > 0)
                  ? "You have completed $completed out of $total topics."
                  : "Get started! Explore $total topics and track your progress.";


                ?>
                <div class="card">
                  <h3><?php echo htmlspecialchars($course); ?></h3>
                  <p><?php echo $progressMessage; ?></p>
                  <a href="courses.php?course=<?php echo urlencode($course); ?>">
                    <!-- <a href="topic.php?course= <?php echo urlencode($course) . '&topic=' . urlencode($course) ?>"> -->
                    <button>Explore Course</button>
                  </a>
                  <p></p>
                  <p> <strong> Progress : </strong> <?php echo $completed; ?>/<?php echo $total; ?> topics completed.</p>

                </div>
              <?php endforeach; ?>

            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </section>
  <script src="../js/script.js"></script>
</body>

</html>

<!-- style of courses -->


<style>
  .course-cards {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
  }

  .card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 22%;
    margin: 10px;
    padding: 15px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    background-color: white;
  }

  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
  }

  .card h3 {
    margin: 10px 0;
    font-size: 1.25rem;
    color: #333;
  }

  .card p {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 15px;
  }

  .card button {
    background-color: #4285f4;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding: 10px 15px;
    font-size: 0.9rem;
    transition: background-color 0.3s, transform 0.2s;
  }

  .card button:hover {
    background-color: 357ae8;
    transform: scale(1.05);
  }

  @media(max-width:768px) {
    .card {
      width: 45%;
    }
  }

  @media(max-width:480px) {
    .card {
      width: 90%;
    }
  }

  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
  }

  /* Styling for the main heading  */
  h1 {
    font-size: 2em;
    font-weight: bold;
    color: black;
    text-align: center;
    margin-bottom: 20px;
  }

  /* Styling for individual topics container */
  .topic-container {
    list-style-type: none;
    padding: 0;
  }

  /* Styling for each topic */
  .topic h2 {
    font-size: 1.2em;
    font-weight: normal;
    color: #333;
    margin: 10px 0;
    position: relative;
    padding-left: 20px;
    /* text-decoration: underline; */
  }

  /* Add dot before the topic name */
  .topic h2::before {
    content: "•";
    position: absolute;
    left: 0;
    top: 0;
    color: #007BFF;
  }

  .topic h2 a {
    /* text-decoration: underline; */
    text-decoration: none;
    color: black;
    transition: color 0.3s ease, text-decoration 0.3s ease;
  }

  .topic h2 a:hover {
    color: blue;
    /* text-decoration: none;  */
    text-decoration: underline;
  }


  iframe {
    margin-top: 20px;
    width: 100%;
    max-width: 600px;
  }
</style>