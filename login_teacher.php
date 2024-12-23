<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // Include your config file here

if (isset($_SESSION["user_id"])) {
    header("Location: teachers/dash.php");
    exit;
}

if (isset($_POST["signin"])) {
    $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
    $pword = mysqli_real_escape_string($conn, md5($_POST["pword"]));

    $check_user = mysqli_query($conn, "SELECT * FROM teacher WHERE uname='$uname' AND pword='$pword'");

    if (mysqli_num_rows($check_user) > 0) {
        $row = mysqli_fetch_assoc($check_user);
        $_SESSION["user_id"] = $row['id']; // Store user ID
        $_SESSION["fname"] = $row['fname'];
        $_SESSION["email"] = $row['email'];
        $_SESSION["dob"] = $row['dob'];
        $_SESSION["gender"] = $row['gender'];
        $_SESSION["uname"] = $row['uname']; // Keep this if you need it later

        // Set user image based on gender
        $_SESSION['img'] = ($row['gender'] == 'M') ? "../img/mp.png" : "../img/fp.png";

        header("Location: teachers/dash.php");
        exit;
    } else {
        echo "<script>alert('Login details are incorrect. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="teachers/css/style.css">
    <title>Login | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
body {
    background-image: url('<?php echo $img; ?>');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
}
</style>
<body>
    <h1><?php echo $greet; ?></h1><br>
    <div class="container" id="container">
        <div class="form-container log-in-container">
            <form action="#" method="post">
                <h1>Examiner Login</h1>
                <br><br>
                <span>Enter credentials</span>
                <input type="text" name="uname" placeholder="Username" value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : ''; ?>" required />
                <input type="password" name="pword" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit" name="signin">Log In</button>
                <a href="signup_teacher.php">Don't have an account? Sign Up</a>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <p>Login as Employee</p>
                    <button style="background-color:#ffffff;border-color:black;"><a href="login_student.php">Continue</a></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
