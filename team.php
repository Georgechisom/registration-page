<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IZI Team</title>
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
            min-height: 100vh;
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
            text-align: center;
            padding: 2% 4%;
            margin-top: 15%;
        }
        @media (max-width: 928px) {
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
            .navbtn {
                display: flex;
            }
        }

        @media (max-width: 480px) {
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
            <h1 style="color: blue; margin-bottom: 4%;">I2I Campus Team</h1>
            <p style="text-align: left;">
                Innovate to impact welcomes all team members on board to our campus tour happening in enugu and abia state. we are thrill you are here. below are tips on how our websites works <br> <br>
                we have the navbar above with contains url of the pages in our website, as a team you can register a user, check the users table, check in a user on the day of the event and search for a particular user, All this can be done using the navbar or the urls below
            </p>
            <h2 style="color: blue; margin: 4% 0%; text-align: left;">Registrations</h2>
            <p style="text-align: left;">
                The registration page <a href="index.php" style="text-decoration: none; color: blue;">index</a> is a page where students can register for the tour by filling the required form. After filling the form the student will obtain a ticket id which will serve as their access to the venue in their respective campus and also a qualification to all that will be happening in the tour. Register a student <a href="index.php" style="text-decoration: none; color: blue;">Here</a>
            </p>
            <h2 style="color: blue; margin: 4% 0%; text-align: left;">Student Table</h2>
            <p style="text-align: left;">
                The student table page <a href="students-info.php" style="text-decoration: none; color: blue;">students-info</a> is a page team members from Innovate to impact can see all the registered student and also vital informations which are as follows
                <ul style="list-style: circle; text-align: left; padding: 2% 7%;">
                    <li style="padding: 1% 0%;">Student full names</li>
                    <li style="padding: 1% 0%;">Student email address</li>
                    <li style="padding: 1% 0%;">Student phone number</li>
                    <li style="padding: 1% 0%;">Student country</li>
                    <li style="padding: 1% 0%;">Student campus</li>
                    <li style="padding: 1% 0%;">State where campus is located</li>
                    <li style="padding: 1% 0%;">Tech knowledge level</li>
                    <li style="padding: 1% 0%;">Volunteers will to change the team</li>
                    <li style="padding: 1% 0%;">Student Ticket Id</li>
                    <li style="padding: 1% 0%;">Date Student Registered</li>
                </ul>
                Check Student tables <a href="students-info.php" style="text-decoration: none; color: blue; text-align: left;">Here</a>
            </p>
            <h2 style="color: blue; margin: 4% 0%; text-align: left;">Student Check Page</h2>
            <p style="text-align: left;">
                The student check page <a href="students_check.php" style="text-decoration: none; color: blue;">students_check</a> is a page team members from Innovate to impact can check in a student into the venue by using their ticket id or their email address, the team member checking the student will have to input the team password which is given; this is to ensure that it's only our team members that can check in a student. <br> Upon inputting the team password and student ticket id or email, you are to click verify using the particular button you are validating with. Immediately you have check in a user by seeing their informations below, pls note that the user table is updated to verified and cannot be changed again. <br> Check in a student <a href="students_check.php" style="text-decoration: none; color: blue; text-align: left;">Here</a>
            </p>
            <h2 style="color: blue; margin: 4% 0%; text-align: left;">Student Search Page</h2>
            <p style="text-align: left;">
                The student Search page <a href="search.php" style="text-decoration: none; color: blue;">search</a> is a page team members from Innovate to impact can search for a student by providing the necessary informations requested. The search can be done using first name or email or school. <br> Search for a student <a href="search.php" style="text-decoration: none; color: blue; text-align: left;">Here</a>
            </p>
            <h2 style="color: blue; margin: 4% 0%; text-align: left;">Campus Event Info</h2>
            <p style="text-align: left;">
                The capmus event info page <a href="tourinfo.php" style="text-decoration: none; color: blue;">tourinfo</a> is a page you can see all the event informations in full which include the event picture, date of various campus event, what we want to do and achieve from the tour, our social media handles, etc <br> View event info <a href="tourinfo.php" style="text-decoration: none; color: blue; text-align: left;">Here</a>
            </p>

            <h3 style="color: blue; margin: 4% 0%; text-align: left;">Thank You</h3>
            <h3 style="color: blue; margin: 4% 0%; text-align: left;">Best Regards: Innovate2impact Engineering Team</h3>
        </div>
    </div>

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