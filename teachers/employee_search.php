<?php date_default_timezone_set('Asia/Kolkata');
session_start();
if (!isset($_SESSION["fname"])) {
    header("Location: ../login_teacher.php");
}
include '../config.php';
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/dash.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Employees</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* .search-employees {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            background-color: #f4f4f9;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        #search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 1rem;
        } */

        #results {
            margin-top: 20px;
        }

        .employee-card {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        #search-count {
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .analytics {
            margin: 20px auto;
            max-width: 800px;
            text-align: center;
        }

        #skillsChart {
            margin-top: 20px;
        }

        #search-bar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            /* Or another background to prevent overlap */
        }

        .search-employees {
            margin: 20px auto;
            max-width: 600px;
        }

        #search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        #results-container {
            max-height: 510px;
            /* Set a max heightf or the results section */
            overflow-y: auto;
            /* Enable vertical scrolling for results */
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .employee-card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #ffffff;
        }

        .employee-card:hover {
            background-color: #e9e9e9;
            /* Highlight on hover for better UX */
        }
    </style>
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
                <a href="employee_search.php" class="active">
                    <i class="bx bx-search"></i>
                    <span class="links_name">Employees</span>
                </a>
            </li>

            <li>
                <a href="courses.php">
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

        <div class="home-content">
            <div>
                <!-- Gopal-<div class="recent-stat box" style="padding: 0px 0px;width:75%;"> -->
                <!-- <div style="padding: 0px 0px;width:75%;"></div> -->
                <div class="analytics">
                    <h2>Employee Skills Distribution</h2>
                    <canvas id="skillsChart" width="400" height="200"></canvas>
                </div>
                <!-- <div class="search-employees">
                    <h2>Search Employees</h2>
                    <input type="text" id="search-bar" placeholder="Search by name or skill..." oninput="searchEmployees()">
                    <p id="search-count" style="font-weight: bold;">Showing 0 of 0 employees</p>

                    <div id="results"></div>
                </div> -->

                <div class="search-employees">
                    <h2>Search Employees</h2>
                    <input type="text" id="search-bar" placeholder="Search by name or skill..." oninput="searchEmployees()">
                    <p id="search-count" style="font-weight: bold;">Showing 0 of 0 employees</p> <!-- Count display -->
                    <br />
                    <div id="results-container">

                        <div id="results">
                            <!-- Results will populate here -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <script src="../js/script.js"></script>
    <script>
        function searchEmployees() {
            const query = document.getElementById('search-bar').value;

            fetch(`employee_search_ajax.php?query=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const resultsDiv = document.getElementById('results');
                    const countDiv = document.getElementById('search-count');

                    // Display counts (filtered and total)
                    countDiv.innerText = `Showing ${data.filtered_count} of ${data.total_count} employees`;

                    resultsDiv.innerHTML = ''; // Clear previous results

                    if (data.employees.length === 0) {
                        resultsDiv.innerHTML = '<p>No employees found.</p>';
                        return;
                    }

                    // Populate employee data
                    data.employees.forEach(employee => {
                        const employeeDiv = document.createElement('div');
                        employeeDiv.classList.add('employee-card');

                        employeeDiv.innerHTML = `
                    <h3>${employee.name}</h3>
                    <p>Email: ${employee.email}</p>
                    <p>Skills: ${employee.skills || 'None listed'}</p>
                `;
                        resultsDiv.appendChild(employeeDiv);
                    });

                    const searchContainer = document.querySelector('.search-employees'); // Parent container of the search bar
                    searchContainer.scrollIntoView({
                        behavior: "smooth", // Smooth scrolling
                        block: "start" // 
                    });
                })
                .catch(error => {
                    console.error('Error fetching employees:', error);
                });
        }

        async function loadSkillsAnalytics() {
            const response = await fetch("employee_analytics.php");
            const data = await response.json();

            const skills = data.map(item => item.skill); // Skill names
            const counts = data.map(item => item.count); // Counts

            // Use Chart.js for analytics visualization
            const ctx = document.getElementById("skillsChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: skills,
                    datasets: [{
                        label: "Employee Skills Count",
                        data: counts,
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Call the function on page load
        document.addEventListener("DOMContentLoaded", loadSkillsAnalytics);
    </script>
</body>

</html>