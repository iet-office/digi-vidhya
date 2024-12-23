<?php
if (isset($_POST['username']) && isset($_POST['percentage']) && isset($_POST['certificate_id'])) {
    $username = htmlspecialchars($_POST['username']);
    $percentage = htmlspecialchars($_POST['percentage']);
    $certificate_id = htmlspecialchars($_POST['certificate_id']);
    $date = date('F j, Y');  // Current date
    $authorized_name = "Gopalakrishna Adusumilli";  // Authorized person's name
    $course_name = ""; // Name of the course
    $company_logo = "logo.png"; // Path to your company logo image
?>
<!DOCTYPE html>
<html>
    <head>
        <style type='text/css'>
            body, html {
                margin: 0;
                padding: 0;
            }
            body {
                color: black;
                display: table;
                font-family: Georgia, serif;
                font-size: 24px;
                text-align: center;
            }
            .container {
                border: 20px solid #66D1FD;;
                width: 750px;
                height: 563px;
                display: table-cell;
                vertical-align: middle;
                position: relative;
            }
            .certificate_id {
                position: absolute;
                top: 10px;
                left: 20px;
                font-size: 16px;
                font-weight: bold;
                color: #333;
            }
            .logo {
                font-size: 32px;
                font-weight: bold;
                color: tan;
                margin-bottom: 30px;
            }
            .marquee {
                color: tan;
                font-size: 48px;
                margin: 20px;
            }
            .assignment {
                margin: 20px;
            }
            .person {
                border-bottom: 2px solid black;
                font-size: 32px;
                font-style: italic;
                margin: 20px auto;
                width: 400px;
            }
            .reason {
                margin: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Serial number at the top left -->
            <div class="certificate_id">
                ID: <?php echo $certificate_id; ?>
            </div>

            <!-- Logo in the center -->
            <div class="logo">
                <img src="<?php echo $company_logo; ?>" alt="Company Logo" width="100" />
            </div>

            <div class="marquee">
                Certificate of Completion
            </div>

            <div class="assignment">
                This certificate is presented to
            </div>

            <div class="person">
                <?php echo $username; ?>
            </div>

            <div class="reason">
                For successfully completing the <?php echo $course_name; ?> course with a score of <?php echo $percentage; ?>%.
            </div>

            <div class="assignment" style="margin-top: 40px;">
                Date: <?php echo $date; ?>
            </div>
            
            <!-- <div class="assignment" style="margin-top: 20px;">
                Authorized by: <?php echo $authorized_name; ?>
            </div> -->

            
        </div>
    </body>

</html>
<?php
} else {
    echo "Please provide valid username, percentage, and serial number.";
}
