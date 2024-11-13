<?php
// Start output buffering to prevent issues with headers
ob_start();
include 'db_connect.php';

// Initialize response variables
$success = false;
$error = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize user input
    $token = mysqli_real_escape_string($con, $_POST['token']);

    // Validate email format
    if ($token === "") {
        $error = "Input Token!";
    } else {
        // Check if the email already exists in the database
        $stmt = $con->prepare("SELECT * FROM `registrations` WHERE verify_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $error = `Oops, something went wrong!`;
        } else {
            // Insert new user record into the database is least than id
            if ($result && $result->num_rows < 1) {
                $error = "Invalid Verification code!";
            } else {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $timestamp =  time() - intval($row['verify_timestamp']);
                // Checking and reseting token
                $timestamp = null;
                $token = null;

                $stmt = $con->prepare("UPDATE `registrations` SET verify_token = ?, verify_timestamp = ? WHERE id = ?");
                $stmt->bind_param("sss", $token, $timestamp, $id);
                    
                $stmt->execute();

                if ($stmt->execute()) {
                    $success = true;
                    // Redirect to continue registration
                    header('location: ./studentregister');
                    exit();
                }else{
                    $error = "This email is already registered";
                }
            }
        }
        $stmt->close();
    }
    $con->close();
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

        <div class="congratDiv">
            <p class="">
                Great Mail verified, we are excited to have you get started <br>
                <strong class="text-center text-warning">
                    Please Enter the token sent to your Email
                </stron>
            </p>
        </div>

        <form action="registerverify.php" method="POST" enctype="multipart/form-data" id="registrationForm">

            <div class="form-group" id="otpDiv">
                    <input type="number" id="token" name="token" class="form-control" placeholder="Enter Token">
                    <div class="error" id="otpError">Please enter the correct correct sent to your email address</div>
            </div>

            <button type="submit" name="otp" class="otpbtn">Verify Token</button>
        </form>

    </div>


    <script src="./js/form-validation.js"></script>
</body>

</html>