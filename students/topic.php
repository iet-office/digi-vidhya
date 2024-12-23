<?php
// Define the course topics array
$course_topics = [
    'Python' => [
        'Data Types' => [
            'description' => <<<EOT
In Python, data types are the classification or categorization of data items. They define the type of a variable and represent the kind of value that tells what operations can be performed on a particular data. Since everything is an object in Python programming, Python data types are classes, and variables are instances (objects) of these classes.<br><br>
The following are the standard or built-in data types in Python:<br>
- Numeric: int, float, complex<br>
- Sequence Type: string, list, tuple<br>
- Mapping Type: dict<br>
- Boolean: bool<br>
- Set Type: set, frozenset<br>
- Binary Types: bytes, bytearray, memoryview<br>
EOT,
            'code' => <<<EOT
example_a = 42 <br>
print(type(example_a))<br>
int <br><br>
example_b = "Hello, Python!" <br>
print(type(example_b))<br>
str
EOT,
            'video' => 'https://www.youtube.com/embed/UKEYTI1V0Vw'
        ],
        'Loops' => [
            'description' => <<<EOT
Python programming language provides two types of Python loops: For loop and While loop to handle looping requirements. Loops in Python provide three ways for executing the loops.<br><br>
Table of Content:<br>
- While Loop in Python<br>
- For Loop in Python<br>
- Nested Loops in Python<br>
- Loop Control Statements<br>
- Internal Working of Loops<br>
EOT,
            'code' => <<<EOT
count = 0 <br>
while (count < 3):<br>
count = count + 1<br>
print("Hello IET")<br><br>
Output:
Hello IET
Hello IET
Hello IET
EOT,
            'video' => 'https://www.youtube.com/embed/WGJJIrtnfpk'
        ],
        'OOP Concepts' => [
            'description' => <<<EOT
Object Oriented Programming is a fundamental concept in Python, empowering developers to build modular, maintainable, and scalable applications. By understanding the core OOP principles—classes, objects, inheritance, encapsulation, polymorphism, and abstraction—programmers can leverage the full potential of Python’s OOP capabilities to design elegant and efficient solutions to complex problems.<br><br>
OOPs Concepts in Python:<br>
- Class in Python<br>
- Objects in Python<br>
- Polymorphism in Python<br>
- Encapsulation in Python<br>
- Inheritance in Python<br>
- Data Abstraction in Python<br>
EOT,
            'code' => 'class Example:\n    def __init__(self, name):\n<br>  
self.name = name\n\nobj = Example("Python")',
            'video' => 'https://www.youtube.com/embed/HeW-D6KpDwY'
        ],
    ],
    'DevOps' => [
        'Fundamentals' => [
            'description' => <<<EOT
In this free DevOps Tutorial we are going to discussed the proper curriculum that you need to cover to become a DevOps Engineer. While getting started with DevOps, you first need to understand the fundamentals of DevOps like what is DevOps, how it works, etc.<br><br>

- Introduction to DevOps<br>
- How DevOps Works?<br>
- Lifecycle of DevOps<br>
- DevOps Pipeline and Methodology<br>
EOT,
            'code' => 'git pull origin main',
            'video' => 'https://www.youtube.com/embed/hQcFE0RD0cQ'
        ],
        'Linux' => [
            'description' => <<<EOT
Linux is one of the most popular operating systems for servers and cloud-based infrastructures. It gives access to a robust CLI, a scripting environment, essential tools and utilities, strong security features, and powerful diagnostic tools for troubleshooting. In order to master the art of delivering high-quality software and infrastructure, it is required for a DevOps Engineer to master Linux.<br><br>

- Linux Commands<br>
- Introduction to Linux Shell Scripting<br>
- How to create a Shell Script<br>
- Introduction to Bash and Bash Scripting<br>
- Linux Networking Tools<br>
EOT,
            'code' => <<<EOT
        # Go back to the home directory <br>
        cd ~ <br><br>
        # Create multiple directories at once<br>
        mkdir dir1 dir2 dir3
        EOT,
            'video' => 'https://www.youtube.com/embed/GzIFoJBVwh8'

        ],
    ],
    'Data Enginner' => [
        'Key Components' => [
            'description' => <<<EOT
       Data engineers deal with large volumes of data, often in real-time, and their role is crucial in enabling businesses to extract valuable insights from their data assets. They work closely with data scientists, analysts, and other stakeholders to ensure that the data infrastructure supports the organization's goals and requirements.<br><br>
       Key Components of Data Engineering:<br>
       - Data Collection<br>
       - Data Storage<br>
       - Data Processing<br>
       - Data Pipelines<br>
       - Data Quality and Governance<br>
     EOT,
            'code' => <<<EOT
         Simple SQL Query (Extracting Data from a Database) <br><br>
         import sqlite3<br>

         # Connect to SQLite database (or any other database with proper libraries)<br>
         conn = sqlite3.connect('example.db')<br>
         cursor = conn.cursor()<br>
         
         # Run a basic SQL query<br>
         cursor.execute("SELECT name, age FROM users WHERE age > 30")<br>
         
         # Fetch all results<br>
         rows = cursor.fetchall()<br>
         
         # Print the results<br>
         for row in rows:<br>
             print(row)<br>
         
         # Close the connection<br>
         conn.close()<br>

        EOT,
            'video' => 'https://www.youtube.com/embed/VaSjiJMrq24'

        ],

    ],
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Topics</title>
    <style>
        .home-content {
            display: flex;
        }

        .stat-boxes {
            display: flex;
        }

        .topics-sidebar {
            width: 25%;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .stat-boxes {
            display: flex;
        }

        h3 {
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        .content-area {
            padding: 20px;
            width: 75%;
        }
    </style>
</head>

<body>

    <div class="header">
        <form action="courses.php" method="get">
            <button type="submit" class="back-button">
                <img src="home-icon.png" alt="Home Icon"> Back to Courses
            </button>
        </form>
    </div>


    <div class="home-content">
        <div class="stat-boxes">
            <div class="topics-sidebar">
                <h3>Topics</h3>
                <ul>
                    <?php
                    $course_name = htmlspecialchars($_GET['course']);
                    if (isset($course_topics[$course_name])) {
                        $topics = $course_topics[$course_name];

                        foreach ($topics as $topic_name => $details) {
                            echo '<li>';
                            echo '<a href="topic.php?course=' . urlencode($course_name) . '&topic=' . urlencode($topic_name) . '">' . htmlspecialchars($topic_name) . '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="content-area">
                <?php

                session_start();
                include '../config.php';

                if (isset($_GET['topic']) && isset($course_topics[$course_name][$_GET['topic']])) {
                    $topic_name = htmlspecialchars($_GET['topic']);
                    $topic_details = $course_topics[$course_name][$topic_name];
                    $userId = $_SESSION['user_id'];
                    $uname = $_SESSION['uname'];

                $query = "
    SELECT topics_done 
    FROM user_progress 
    WHERE uname = '$uname' AND course_name = '$course_name'
    ";
                    $result = mysqli_query($conn, $query);

                    $progress = mysqli_fetch_assoc($result);

                    // foreach ($progress as $key => $value) {
                    //     echo "$key: $value\n";
                    // }

                    $topicsDone = isset($progress['topics_done']) ? explode(',', $progress['topics_done']) : [];
                    $isCompleted = in_array($topic_name, $topicsDone);
                ?>
                    <h1><?php echo $topic_name; ?> in <?php echo $course_name; ?></h1>

                    <p><?php echo $topic_details['description']; ?></p>
                    <h3>Example:</h3>
                    <pre><?php echo $topic_details['code']; ?></pre>
                    <h3>Video Tutorial:</h3>
                    <iframe width="560" height="315" src="<?php echo $topic_details['video']; ?>" frameborder="0" allowfullscreen></iframe>

                    <div style="margin-top: 20px;">
                        <label>
                            <input type="checkbox" id="completion-checkbox"
                                data-course-name="<?php echo $course_name; ?>"
                                data-topic-name="<?php echo $topic_name; ?>"
                                <?php echo $isCompleted ? 'checked' : ''; ?>>
                            Mark as Completed
                        </label>
                    </div>

                <?php
                } else {
                    echo '<p>Topic not found!</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('completion-checkbox').addEventListener('change', function() {
            const isChecked = this.checked;
            const courseName = this.getAttribute('data-course-name');
            const topicName = this.getAttribute('data-topic-name');

            // Send an AJAX request to update the database
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_progress.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Prepare the data to send
            const params = `course=${encodeURIComponent(courseName)}&topic=${encodeURIComponent(topicName)}&status=${isChecked ? 1 : 0}`;
            xhr.send(params);

            // Handle the server response
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Progress updated successfully:', xhr.responseText);
                } else {
                    console.error('Error updating progress:', xhr.responseText);
                }
            };
        });
    </script>

<style>
    /* Header Styles */
    .header {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #f4f4f4;
        border-bottom: 1px solid #ddd;
    }
    .header button.back-button {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .header button.back-button:hover {
        background-color: #0056b3;
    }
    .header button img {
        width: 20px;
        height: 20px;
        margin-right: 8px;
    }
    .header h1 {
        margin: 0;
        margin-left: auto;
        font-size: 20px;
        color: #333;
    }
</style>


</body>

</html>
