<?php
// Start output buffering
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include your config file here

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["signup"])) {
    // Escape and sanitize form inputs
    $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
    $pword = mysqli_real_escape_string($conn, $_POST["pword"]);
    $confirm_pword = mysqli_real_escape_string($conn, $_POST["confirm_pword"]);
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);

    $error_message = '';

    // List of allowed emails
    $allowed_emails = [
        'arfin.parween@ielektron.com',
        'gopalakrishna@ielektron.com',
        'gorantla.karthik@ielektron.com',
        'arunjith.tv@ielektron.com',
        'aman.akram@ielektron.com'
    ];

    // Check if the email is allowed
    if (!in_array($email, $allowed_emails)) {
        $error_message = 'Signup is restricted to specific email addresses. Please use an authorized email.';
    } elseif ($pword !== $confirm_pword) {
        $error_message = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pword)) {
        $error_message = 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    } else {
        // Hash the password
        $hashed_pword = md5($pword);

        // Check if the username or email already exists
        $check_existing_user = mysqli_query($conn, "SELECT * FROM teacher WHERE uname='$uname' OR email='$email'");
        
        if (mysqli_num_rows($check_existing_user) > 0) {
            $error_message = 'Username or Email already exists. Please try with different credentials.';
        } else {
            // Insert teacher details into the teacher table
            $query = "INSERT INTO teacher (uname, pword, fname, email, dob, gender, subject) VALUES ('$uname', '$hashed_pword', '$fname', '$email', '$dob', '$gender', '$subject')";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Signup successful! Redirecting to login...');</script>";
                header("Location: login_teacher.php");
                exit();
            } else {
                $error_message = 'Error: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="teachers/css/style.css">
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Examiner Signup | Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Examiner Signup</h1>
    <div class="container">
        <form action="#" method="post">
            <h2>Create an Examiner Account</h2>
            <?php
            // Display error message if it exists
            if (!empty($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
            <input type="text" name="uname" placeholder="Username" required />
            <input type="text" name="fname" placeholder="Full Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="text" id="dob" name="dob" placeholder="Date of Birth (dd/mm/yyyy)" required />
            <div class="gender-selection">
                <label>Gender:</label>
                <input type="radio" name="gender" value="M" id="male" required />
                <label for="male">Male</label>
                <input type="radio" name="gender" value="F" id="female" required />
                <label for="female">Female</label>
            </div>
            <input type="text" name="subject" placeholder="Subject" required />
            <input type="password" name="pword" placeholder="Password" required />
            <input type="password" name="confirm_pword" placeholder="Confirm Password" required />
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login_teacher.php">Log In</a></p>
    </div>

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for the date input
        flatpickr("#dob", {
            dateFormat: "d/m/Y", // Display format: dd/mm/yyyy
            maxDate: "today",    // Prevent selecting future dates
        });
    </script>
</body>
<style>
    .gender-selection {
        display: flex;
        align-items: center;
    }

    .gender-selection label {
        margin-right: 10px;
    }

    .gender-selection input[type="radio"] {
        margin: 0 5px;
    }
</style>
</html>

<?php
// Flush the output buffer
ob_end_flush();
?>
