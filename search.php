<?php
// Start output buffering to prevent issues with headers
ob_start();
include 'db_connect.php';

$output = "";

if (isset($_POST['search'])) {
    $searchq = trim($_POST['search']);
    // $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);

        $sql = "SELECT * FROM registrations WHERE first_name LIKE '%$searchq%' OR last_name LIKE '%$searchq%' OR school LIKE '%$searchq%' OR email LIKE '%$searchq%' OR phone LIKE '%$searchq%' OR state LIKE '%$searchq%' OR expertise LIKE '%$searchq%' OR ticket_id LIKE '%$searchq%' OR volunteer LIKE '%$searchq%' OR checked LIKE '%$searchq%'";

        $count = $con->query($sql);

        if ($count->num_rows > 0) {
            // while ($row = mysql_fetch_array($query)) {
            while($row = $count->fetch_array()){
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $email = $row['email'];
                $school = $row['school'];
                $phone = $row['phone'];
                $state = $row['state'];
                $expertise = $row['expertise'];
                $ticket_id = $row['ticket_id'];
                $volunteer = $row['volunteer'];
                $checked = $row['checked'];
                $country = $row['country'];
                $created_at = $row['created_at'];
                $id = $row['id'];
                        
                $output .= '<div style="color:#0000FF;">' .$first_name.' '.$last_name. '<br>' .$email. '<br>' .$school. '<br>' .$phone. '<br>' .$state. '<br>' .$expertise. '<br>' .$ticket_id. '<br>' .$volunteer. '<br>' .$checked. '<br>' .$country. '<br>' .$created_at. '<br> <br> </div>';
            }
        } else {
            $output = "there was not search result !";
        }

}

$con->close();

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I2I Student Search</title>
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
            height: 100%;
        }

        h1 {
        text-align: center;
        color: blue;
        margin-bottom: 30px;
        font-weight: bold;
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
        .bigtwo{
            display: grid; 
            grid-template-columns: 1fr; 
            justify-content: center; 
            gap: 2%;
        }

        .checker{
            width: 100%;
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
            margin-bottom: 4%;
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
        .container{
            background: linear-gradient(135deg, #f5f7fa 0%, #c8ced8 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: "Open Sans", sans-serif;
            height: auto;
            box-sizing: content-box;
        }
        .notediv{
            background-color: white;
            box-shadow: 0 15px 45px -20px blue;
            width: 100%;
            height: auto;
            text-align: left;
            padding: 2% 4%;
            margin-top: 15%;
            box-sizing: content-box;
        }

        @media (max-width: 928px) {
            .bigtwo{
                display: grid;
                grid-template-columns: 1fr;
                gap: 2%;
            }
            h1 {
                margin-bottom: 30px;
                font-size: 22px;
            }
            .checker{
                padding: 1% 0%;
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
            <h1 style="margin-top:5%;">I2I Student Search</h1>
            <div class="bigtwo">
                <div style="width: 100%;">
                    <div style="color: blue; padding: 2% 0%;">
                        Search for a Student
                    </div>
                    <form action="search.php" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="text" name="search" id="" placeholder="Search Student" style="border: 1px solid blue; color: blue;">
                        </div>

                        <input type="submit" style="background-color: blue; color: white; border: none; font-weight: bold;" value="Search Student" />
                    </form>
                </div>
            </div>
            <div class="checker">
                <div>
                    <div class="userdiv">Search Result: <?php echo $output; ?></div>
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