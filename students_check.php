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
$checked = "";
$created_at = "";

// Check if the form has been submitted
if (isset($_POST['ticket'])) {

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
                // header("Location: ./tourinfo");
            } else {
                // Sanitize user input
                $ticket_id = mysqli_real_escape_string($con, $_POST['ticket_id']);

                // Validate ticket format
                if ($ticket_id === "") {
                    $error = "Input ticket Field!";
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

                            $checked = "VERIFIED";

                            $stmt = $con->prepare("UPDATE `registrations` SET checked = ? WHERE id = ?");
                            $stmt->bind_param("ss", $checked, $id);
                                
                            $stmt->execute();

                            // Checking student exist
                            $firstname = $row['first_name'];
                            $lastname = $row['last_name'];
                            $email = $row['email'];
                            $phone = $row['phone'];
                            $country = $row['country'];
                            $state = $row['state'];
                            $school = $row['school'];
                            $expertise = $row['expertise'];
                            $checked = $row['checked'];
                            $volunteer = $row['volunteer'];
                            $created_at = $row['created_at'];
                        }
                    }

                }
            }
        }
    }
}
if (isset($_POST['myemail'])) {

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
                // header("Location: ./tourinfo");
            } else {
                // Sanitize user input

                $email = trim($_POST['email']);

                // Validate email format
                if ($email === "") {
                    $error = "Input Email Field!";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "Invalid Email!";
                } else {
                    $stmt = $con->prepare("SELECT * FROM `registrations` WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$result) {
                        $error = `Oops, something went wrong!`;
                    } else {
                        // Insert new user record into the database is least than id
                        if ($result && $result->num_rows < 1) {
                            $error = "Email not Found!";
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['id'];

                            $checked = "VERIFIED";

                            $stmt = $con->prepare("UPDATE `registrations` SET checked = ? WHERE id = ?");
                            $stmt->bind_param("ss", $checked, $id);
                                
                            $stmt->execute();

                            // Checking student exist
                            $firstname = $row['first_name'];
                            $lastname = $row['last_name'];
                            $email = $row['email'];
                            $phone = $row['phone'];
                            $country = $row['country'];
                            $state = $row['state'];
                            $school = $row['school'];
                            $expertise = $row['expertise'];
                            $checked = $row['checked'];
                            $volunteer = $row['volunteer'];
                            $created_at = $row['created_at'];
                        }
                    }
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
    <title>I2I Ticket Check</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }

        body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c8ced8 100%);
        min-height: 100vh;
        font-family: "Open Sans", sans-serif;
        }

        h1 {
        text-align: center;
        color: blue;
        margin-bottom: 30px;
        font-weight: bold;
        margin-top: 5%;
        }

        .form-group {
        margin-bottom: 20px;
        }

        label {
        display: block;
        margin-bottom: 10px;
        color: blue;
        font-weight: 600;
        }

        input,
        select {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        }

        input:focus,
        select:focus {
        outline: none;
        border-color: #3498db;
        }
        button {
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s ease;
        }

        button:hover {
        background-color: blue;
        }
        .ticketbot {
            text-align: center;
            background-color: blue; 
            color: white; 
            font-weight: bold;
        }
        .ticketbot:hover{
            background-color: white; 
            color: blue; 
            border: 2px solid blue;
        }
        .emailbot {
            text-align: center;
            background-color: blue; 
            color: white; 
            font-weight: bold;
        }
        .emailbot:hover{
            background-color: white; 
            color: blue; 
            border: 2px solid blue;
        }
        /* .big{
            box-shadow: 0 15px 45px -20px blue; 
            background-color: white; 
            padding: 30px; 
            border-radius: 10px; 
            width: 100%; 
            max-width: 800px;
        } */
        .container{
            background: linear-gradient(135deg, #f5f7fa 0%, #c8ced8 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: "Open Sans", sans-serif;
        }
        .notediv{
            background-color: white;
            box-shadow: 0 15px 45px -20px blue;
            width: 100%;
            text-align: left;
            padding: 2% 4%;
            margin-top: 15%;
        }
        .bigtwo{
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            justify-content: center; 
            align-content: center; 
            gap: 4%;
        }

        .checker{
        margin-top: 5%;
        width: 100%;
        padding: 0% 4%;
        border-left: 1px solid blue;
        }

        .userdiv{
        border-bottom: 1px solid blue;
        border-right: 1px solid blue;
        margin-bottom: 5%;
        padding: 2% 0%;
        font-weight: 800;
        color: blue;
        }

        .userspan{
        font-weight: 500;
        }
        .buttonss{
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 2%;
        }
        .adminfirstview{
            color: blue;
            display: flex;
            justify-content: space-between;
            padding: 0% 2%;
            margin-top: 10%;
            margin-bottom: 5%;
        }

        .navbar{
            background-color: white;
            box-shadow: 0 15px 45px -20px blue;
            position: fixed;
            width: 100%;
            padding: 1% 1%;
            z-index: 10;
        }
        .navdiv{
            display: flex;
            gap: 5%;
            padding: 20px;
            justify-content: space-evenly;
            align-items: center;
        }
        a{
            text-decoration: none;
        }
        ul{
            list-style: none;
        }
        .firstanchor{
            font-size: 20px;
            color: blue;
            font-weight: bold;
        }
        .navfirdiv{
            width: 100%;
        }
        .navsecdiv{
            display: flex;
            gap: 2%;
            padding: 0% 15%;
            justify-content: space-evenly;
        }
        .eachli{
            width: 100%;
        }
        .secanchor{
            color: blue;
        }
        .secanchor:hover{
            font-style: italic;
            text-decoration: underline;
        }
        .navbtn{
            width: 6%;
            padding: 1% 1%;
            display: none;
            flex-flow: column;
            border: 2px solid blue;
            background-color: white;
            border-radius: 10%;
        }
        .btnspan{
            color: blue;
            border-bottom: 2px solid blue;
            margin-bottom: 15%;
            width: 100%;
        }
        .btnspanl{
            color: blue;
            width: 100%;
            border-bottom: 2px solid blue;
        }
        .navfirclickdiv{
            width: 100%;
            display: none;
        }
        .navjaclick{
            display: flex;
            flex-flow: column;
            column-gap: 5%;
            padding: 1% 0%;
            text-align: center;
        }
        .clickli{
            margin-bottom: 2%;
        }
        .navbtnclose{
            display: none;
            justify-content: center;
            align-items: center;
            background-color: white;
            width: auto;
            border: none;
            padding: 0% 0%;
        }
        .close{
            font-size: 35px;
            color: blue;
            border: 2px solid blue;
            border-radius: 10%;
            padding: 0% 50%;
        }

        @media (max-width: 928px) {
            .bigtwo{
                display: grid;
                grid-template-columns: 1fr;
                gap: 3%;
            }
            h1 {
                margin-bottom: 30px;
                font-size: 22px;
            }
            .checker{
                border-left: none;
                border-top: 1px solid blue;
                padding: 5% 0%;
            }
            .ticketbot{
                margin-bottom: 5%;
            }
            .buttonss{
                display: grid; 
                grid-template-columns: 1fr; 
                gap: 5%;
            }
            .adminfirstview{
                margin-top: 2%;
            }
            .navdiv{
                justify-content: space-between;
            }
            .navfirdiv{
                display: none;
            }
            .navbtn {
                display: flex;
            }
            .navbtnclose{
                padding: 1% 1%;
            }
            .close{
                font-size: 25px;
            }
            .notediv{
                margin-top: 20%;
            }
        }

        @media (max-width: 768px) {
            .bigtwo{
                display: grid;
                grid-template-columns: 1fr;
                gap: 3%;
            }
            .navbtn {
                display: flex;
            }
        }

        @media (max-width: 480px) {
            input,
            select {
                padding: 10px;
            }

            .bigtwo{
                display: grid;
                grid-template-columns: 1fr;
                gap: 3%;
            }
            .navbtn {
                display: flex;
                width: 10%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
          <a href="team.php" class="firstanchor">
              <div class="preleg">Innovate2impact</div>
          </a>
          <div class="navfirdiv">
            <ul class="navsecdiv">
              <li class="eachli">
                <a class="secanchor" aria-current="page" href="team.php">Home</a>
              </li>
              <li class="eachli" >
                <a class="secanchor" href="index.php"> Register</a>
              </li>
              <li class="eachli">
                <a class="secanchor" href="students-info.php">Table</a>
              </li>
              <li class="eachli">
                <a class="secanchor" href="students_check.php">Check</a>
              </li>
              <li class="eachli">
                <a class="secanchor" href="search.php">Search</a>
              </li>
              <li class="eachli">
                <a class="secanchor" href="tourinfo.php"> Event Info </a>
              </li>
            </ul>
          </div>
          <button class="navbtn">
            <span class="btnspan"></span>
            <span class="btnspan"></span>
            <span class="btnspanl"></span>
          </button>
          <button class="navbtnclose">
            <span class="close">x</span>
          </button>
        </div>
        <div class="navfirclickdiv">
            <ul class="navjaclick">
              <li class="eachli clickli">
                <a class="secanchor" aria-current="page" href="team.php">Home</a>
              </li>
              <li class="eachli clickli">
                <a class="secanchor" href="index.php"> Register User</a>
              </li>
              <li class="eachli clickli">
                <a class="secanchor" href="students-info.php">Students Table</a>
              </li>
              <li class="eachli clickli">
                <a class="secanchor" href="students_check.php">Check Student</a>
              </li>
              <li class="eachli clickli">
                <a class="secanchor" href="search.php">Search Student</a>
              </li>
              <li class="eachli">
                <a class="secanchor" href="tourinfo.php"> Event Info </a>
              </li>
            </ul>
          </div>
    </nav>

    <div class="container">
        <div class="notediv">
            <h1>I2I Campus Tour Student Info</h1>
            <div class="bigtwo">
                <div style="width: 100%;">
                    <div class="adminfirstview">
                        <p >Total Users</p>
                        <p class="" style="font-weight: bold;">
                        <?php
                        $sql = "SELECT * FROM registrations WHERE role = 'student' ORDER BY id DESC";
                        $query = mysqli_query($con, $sql);
                        echo $numRow = mysqli_num_rows($query); ?>
                        </p>
                    </div>
                    <div style="color: blue; padding: 2% 0%;">
                        Verify user using either ticket number or email
                    </div>
                    <div style="color: red; padding: 2% 0%;">
                        <?php echo $error ?>
                    </div>
                    <form action="students_check.php" method="POST" enctype="multipart/form-data" id="registrationForm">

                        <div class="form-group">
                            <label for="ticket" style="color: blue; font-weight: bold;">Verify Admin</label>
                            <input type="type" name="role" class="form-control" placeholder="Enter Admin Password" style="border: 1px solid blue; color: blue;">
                        </div>
                        <div class="form-group">
                            <label for="ticket" style="color: blue; font-weight: bold;">Verify Registration Code</label>
                            <input type="type" name="ticket_id" class="form-control" placeholder="Enter ticket code" style="border: 1px solid blue; color: blue;">
                        </div>

                        <div class="form-group">
                            <label for="email" style="color: blue; font-weight: bold;">Verify Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter user email" style="border: 1px solid blue; color: blue;">
                        </div>

                        <div class="buttonss">
                            <button type="submit" name="ticket" class="ticketbot" >Verify Via Ticket</button>
                            <button type="submit" name="myemail" class="emailbot" >Verify Via Email</button>
                        </div>
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
                        <div class="userdiv">School: <span class="userspan"><?php echo $school ?></span></div>
                        <div class="userdiv">Expertise: <span class="userspan"><?php echo $expertise ?></span></div>
                        <div class="userdiv">Volunteer: <span class="userspan"><?php echo $volunteer ?></span></div>
                        <div class="userdiv">User Check: <span class="userspan"><?php echo $checked ?></span></div>
                        <div class="userdiv">Registration Date: <span class="userspan"><?php echo $created_at ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/form-validation.js"></script>
    <script>
        const openBtn = document.querySelector(".navbtn");
        const closeBtn = document.querySelector(".navbtnclose");
        const showDiv = document.querySelector(".navfirclickdiv");

        openBtn.onclick = () => {
            showDiv.style.display = "block";
            closeBtn.style.display = "flex";
            openBtn.style.display = "none";
        };

        closeBtn.onclick = () => {
            showDiv.style.display = "none";
            closeBtn.style.display = "none";
            openBtn.style.display = "flex";
        };
    </script>
</body>
</html>