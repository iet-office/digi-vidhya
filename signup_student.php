<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include your config file here

// Initialize an error message variable
$error_message = "";

if (isset($_POST["signup"])) {
    // Escape and sanitize form inputs
    $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
    $pword = mysqli_real_escape_string($conn, $_POST["pword"]);
    $confirm_pword = mysqli_real_escape_string($conn, $_POST["confirm_pword"]);
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);

    // Validate email domain
    if (substr($email, -14) !== '@ielektron.com') {
        $error_message = "Invalid email ID. Email must end with '@ielektron.com'.".substr($email, -14);
    }
    // Check if passwords match
    elseif ($pword !== $confirm_pword) {
        $error_message = "Passwords do not match. Please try again.";
    }
    // Validate password strength
    elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $pword)) {
        $error_message = "Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        $hashed_pword = md5($pword); // Hash the password

        // Check if the username or email already exists
        $check_existing_user = mysqli_query($conn, "SELECT * FROM student WHERE uname='$uname' OR email='$email'");
        
        if (mysqli_num_rows($check_existing_user) > 0) {
            $error_message = "Username or Email already exists. Please try with different credentials.";
        } else {
            // Insert user details into the student table
            $query = "INSERT INTO student (uname, pword, fname, email, dob, gender) VALUES ('$uname', '$hashed_pword', '$fname', '$email', '$dob', '$gender')";
    
            if (mysqli_query($conn, $query)) {
                // Redirect to login page after successful signup
                header("Location: login_student.php");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="students/css/style.css">
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Signup | Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Signup</h1>
    <div class="container">
        <form action="#" method="post">
            <h2>Create an Account</h2>
            <?php
                // Display the error message if it's set
                if (!empty($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                }
            ?>
            <input type="text" name="uname" placeholder="Username" required />
            <input type="text" name="fname" placeholder="First Name" required />
            <input type="email" name="email" placeholder="Enter your work mail ID" required />
            <input type="text" id="dob" name="dob" placeholder="Date of Birth (dd/mm/yyyy)" required />
            <div class="gender-selection">
                <label>Gender:</label>
                <input type="radio" name="gender" value="M" id="male" required />
                <label for="male">Male</label>
                <input type="radio" name="gender" value="F" id="female" required />
                <label for="female">Female</label>
            </div>
            <input type="password" name="pword" placeholder="Password" required pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" 
            title="Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character." />
            <input type="password" name="confirm_pword" placeholder="Confirm Password" required />
            <p style="font-size: 12px; color: gray;">Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one number, and one special character.</p>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <div style="text-align: center; margin-top: 20px;">
            <p>Already have an account?</p>
            <a href="login_student.php" style="text-decoration: none;">
                <button style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Log In</button>
            </a>
        </div>
    </div>

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for the Date of Birth field
        flatpickr("#dob", {
            dateFormat: "d/m/Y", // Placeholder format: dd/mm/yyyy
            maxDate: "today",    // Prevent future dates
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

    button {
        cursor: pointer;
    }

    button:hover {
        opacity: 0.9;
    }

    /* Ensure error message styling does not hide the form or button */
    p {
        margin: 5px 0;
    }
</style>
</html>
