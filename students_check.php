<?php
// Start output buffering to prevent issues with headers
ob_start();
include 'db_connect.php';

// Initialize response variables
$success = false;
$error = '';
$email = "";
$firstname = "";
$lastname = "";
$phone = "";
$country = "";
$state = "";
$school = "";
$expertise = "";
$volunteer = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $role = mysqli_real_escape_string($con, $_POST['role']);
 
    if ($role === "") {
        $error = "User Fields cannot be empty!";
    } else {

        $stmt = $con->prepare("SELECT * FROM `registrations` WHERE role = ?");
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $error = "Oops, something went wrong!";
        } else {
            $row = mysqli_fetch_assoc($result);
            $roles = $row['role'];

            if ($roles != 'purity') {
                $error = "You are not authorized to view this info";
                header("Location: ./tourinfo");
            } else {
                // Sanitize user input
                $ticket_id = mysqli_real_escape_string($con, $_POST['ticket_id']);

                // Validate email format
                if ($ticket_id === "") {
                    $error = "Input Registration Code!";
                } else {
                    // Check if the ticket no exists in the database
                    $stmt = $con->prepare("SELECT * FROM `registrations` WHERE ticket_id = ?");
                    $stmt->bind_param("s", $ticket_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$result) {
                        $error = `Oops, something went wrong!`;
                    } else {
                        // Insert new user record into the database is least than id
                        if ($result && $result->num_rows < 1) {
                            $error = "No Registration Code Found!";
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['id'];
                            // Checking student exist
                            $firstname = $row['first_name'];
                            $lastname = $row['last_name'];
                            $email = $row['email'];
                            $phone = $row['phone'];
                            $country = $row['country'];
                            $state = $row['state'];
                            $school = $row['school'];
                            $expertise = $row['expertise'];
                            $volunteer = $row['volunteer'];
                        }
                    }
                    $stmt->close();
                }
            }
        }
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
    <title>I2I Ticket Check</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="bigs">
        <h1>I2I Campus Tour Student Info</h1>
        <div class="bigcheck">
            <div class="firstcheck">
                <div style="color: red; padding: 2% 0%;">
                    <?php echo $error ?>
                </div>
                <form action="students_check.php" method="POST" enctype="multipart/form-data" id="registrationForm">

                    <div class="form-group">
                        <label for="ticket">Verify User</label>
                        <input type="type" name="role" class="form-control" placeholder="Who are you" >
                    </div>
                    <div class="form-group">
                        <label for="ticket">Verify Registration Code</label>
                        <input type="type" name="ticket_id" class="form-control" placeholder="Enter ticket code">
                    </div>
                    <button type="submit" name="verify" class="emailbtn">Verify Ticket</button>
                </form>
            </div>
            <div class="checker">
                <div>
                    <div class="userdiv">First Name: <span class="userspan"><?php echo $firstname ?></span></div>
                    <div class="userdiv">Last Name: <span class="userspan"><?php echo $lastname ?></span></div>
                    <div class="userdiv">Email: <span class="userspan"><?php echo $email ?></span></div>
                    <div class="userdiv">Phone Number: <span class="userspan"><?php echo $phone ?></span></div>
                    <div class="userdiv">Country: <span class="userspan"><?php echo $country ?></span></div>
                    <div class="userdiv">State: <span class="userspan"><?php echo $state ?></span></div>
                    <div class="userdiv">Expertise: <span class="userspan"><?php echo $expertise ?></span></div>
                    <div class="userdiv">Volunteer: <span class="userspan"><?php echo $volunteer ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/form-validation.js"></script>
</body>
</html>