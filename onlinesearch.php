<?php
// Start output buffering to prevent issues with headers
ob_start();
include 'db_connect.php';

$error = "";
$success = false;

$myresult = "";
$noresult = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$realsearch = trim($_POST['realsearch']);
    $realcolumn = trim($_POST['realcolumn']);

    $sql = "select * from registrations where $realcolumn like '%$realsearch%'";

    $result = $con->query($sql);
    

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            
            $myresult = $row["first_name"]."<br> 
            ".$row["last_name"]."<br> ".$row["email"]."<br>  ".$row["school"]."<br> ".$row["phone"]."<br> ".$row["expertise"]."<br> ".$row["country"]."<br>  ".$row["state"]."<br> ".$row["school"]."<br> ".$row["volunteer"]."<br> ".$row["ticket_id"]."<br> ".$row["checked"]."<br> ".$row["created_at"]."<br>";
        }
    } else {
        $noresult = "No record found";
    }

} else {
    
};

$con->close();

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
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        font-family: "Open Sans", sans-serif;
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
        .big{
            box-shadow: 0 15px 45px -20px blue; 
            background-color: white; 
            padding: 30px; 
            border-radius: 10px; 
            width: 100%; 
            max-width: 800px;
        }
        .bigtwo{
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            justify-content: center; 
            align-items: center; 
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
            margin-bottom: 4%;
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
        }

        @media (max-width: 768px) {
            .bigtwo{
                display: grid;
                grid-template-columns: 1fr;
                gap: 3%;
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
        }
    </style>
</head>
<body>
    <div class="big">
        <h1>I2I Student Search</h1>
        <div class="bigtwo">
            <div style="width: 100%;">
                <div style="color: blue; padding: 2% 0%;">
                    Search for a Student
                </div>
                <form action="search.php" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="text" name="realsearch" id="" placeholder="Search Student" style="border: 1px solid blue; color: blue;">
                    </div>

                    <select name="realcolumn" style="border: 1px solid blue; color: blue; margin-bottom: 4%;">
                        <option value="" selected disabled>search student under</option>
                        <option value="first_name">first Name</option>
                        <option value="school">school</option>
                        <option value="email">Email</option>
                    </select><br>

                    <button type="submit" name="mysearch" class="ticketbot" >Search Student</button>
                </form>
            </div>
            <div class="checker">
                <div>
                    <div class="userdiv">Search Result: <span class="userspan"><?php echo $myresult; echo $noresult; ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/form-validation.js"></script>
</body>
</html>