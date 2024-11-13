<?php
// Start output buffering to prevent issues with headers
ob_start();
include 'db_connect.php';

// Initialize response variables
$success = false;
$error = '';

// Check if the form has been submitted
if (!isset($_POST['verify'])) {
    $error = "Welcome Kindly validate your email";
} else {

    // Sanitize user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $token = rand(100000,999999);

    // Validate email format
    if ($email === "") {
        $error = "Fields cannot be empty!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid Email!";
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM registrations WHERE email = ?";
        $stmt = mysqli_stmt_init($con);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s",  $email);

        $execute = mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $numRows = mysqli_num_rows($result);

        if (!$execute) {
            $error = "Oops, something went wrong!";
        } elseif ($numRows > 0) {
                $error = "Account already exists!";
        } else {
            // Insert new user record into the database
            $sql = "INSERT INTO registrations(email) VALUE(?)";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s",$email);

            $execute = mysqli_stmt_execute($stmt);

            $sql = "UPDATE registrations SET verify_token = ?, verify_timestamp = ? WHERE email = ?";
            $stmt = mysqli_stmt_init($con);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt,"sss", $token, $timestamp, $email);
        
            $execute = mysqli_stmt_execute($stmt);


            if (!$execute) {
                $error = "Oops, something went wrong!";
            } else {
                $success = true;
                // Redirect to the next registration page
                header('location: ./registerverify');
                // send mail
                $to = $email;
                $subject = "Verify Your Account";
                $message = "
                    <div style=\"padding: 10px; background-color: #468ce2; color: #ffffff;\">
                    Please use the one time verification (OTP) to verify your account: <br> <h1 style=\"text-align: center;  color: #ffffff\">'$token' </h1> <br>
                    Thank you <br>
                    <h3>Innovatetoimpact<h3> <br>
                    </div>
                ";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: Innovatetoimpact <info@innovatetoimpact.org>' . "\r\n";

                $mail = mail($to, $subject, $message, $headers);

                if (!$mail) {
                    $error = "Failed to verification token, please try again!";
                }else{
                    $success = true;
                    header("Location: ./registerverify"); 
                }
            }
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Portal</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h1>I2I Campus Tour</h1>
        <div style="color: red; padding: 2% 0%;">
            <?php echo $error ?>
        </div>
        <form action="index.php" method="POST" enctype="multipart/form-data">

            <div class="form-group" id="emailDiv">
                    <label for="email">Validate your Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your Email" required>
                    <div class="error" id="emailError">Please enter a valid email address</div>
            </div>

            <button type="submit" name="verify" class="emailbtn">Verify Mail</button>
        </form>
    </div>

    <script src="./js/form-validation.js"></script>
    <!-- <script src="./js/form-pages.js"></script> -->
</body>

</html>