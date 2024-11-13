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
    $firstname = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $school = mysqli_real_escape_string($con, $_POST['school']);
    $expertise = mysqli_real_escape_string($con, $_POST['expertise']);
    $role = "student";
    $volunteer = mysqli_real_escape_string($con, $_POST['volunteer']);
    $ticket_id = "I2I" . rand(100000,999999);

    // Validate fields
    if ($firstname === "" || $lastname === "" || $email === "" || $phone === "" || $country === "" || $state === "" || $school === "" || $expertise === "" || $volunteer === "") {
        $error = "Fields cannot be empty!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($phone < 11) {
        $error = "Error in Phone digits Check again!";
    } else {
        // Check if the email already exists in the database
        $stmt = $con->prepare("SELECT * FROM `registrations` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows < 1) {
            $error = "This email is not found";
        } else {
            // update user record into the database
            $stmt = $con->prepare("UPDATE `registrations` SET first_name = ?, last_name = ?, phone = ?, country = ?, state = ?, school = ?, expertise = ?, role = ?, volunteer = ?, ticket_id = ? WHERE email = ?");
            $stmt->bind_param("sssssssssss", $firstname, $lastname, $phone, $country, $state, $school, $expertise, $role, $volunteer, $ticket_id, $email);

            if ($stmt->execute()) {
                $success = true;
                // redirect students to telegram
                header('location: https://t.me/+6V-OlkMhN_g1ZGE0');
                // send mail
                $to = $email;
                $subject = "Successful Registration";
                $message = "
                    <div style=\"padding: 10px; background-color: #ffffff; color: #000000;\">
                        Congratulations! You've registered <br> <br> Dear <strong style=\"color: #000000\">'$firstname' '$lastname' </strong> <br> <br>
                        Congratulations on successfully registering for the Southeast Campus Tour! We're thrilled to have you on board. <br>
                        Your Registration Code <br> <h1 style=\"text-align: center;  color: #008000\">'$ticket_id'</h1> <br>
                        This code would serve as your access code to the venue. <br> <br>
                        Customize Your DP: Click this link to generate your personalized event DP: <a href=\"https://getdp.co/qPm\" style=\"text-decoration: none; color: #008000; cursor:pointer\">https://getdp.co/qPm</a> <br> <br>
                        <img src=\"./GSLZ2161.JPG\" alt=\"eventImage\" style=\"width: 100%;\"> <br> <br>
                        Event Details: <br> <br>
                        <ul>
                            <li>
                                Date: Friday, 22nd of November (Enugu) and Wednesday, 27th of November (Abia)
                            </li> <br>
                            <li>
                                Time: 9:00 AM
                            </li> <br>
                            <li>
                                Venue: Coal City University (Enugu) and Abia State Polytechnic (Abia)
                            </li>
                        </ul> <br><br>
                        What To Expect <br> <br>
                        <ul>
                            <li>Inspiring keynotes and panel discussions</li> <br>
                            <li>Interactive sessions with industry experts</li> <br>
                            <li>Networking opportunities with innovators and change-makers</li> <br>
                            <li>Growth and learning experiences</li> <br>
                            <li>Scholarship opportunities</li>
                        </ul> <br> <br>
                        Social Media: <br> <br>
                        Follow us on X ( Twitter ), Instagram, Linkedin for updates and behind-the-scenes peeks. <br> <br>
                        Innovatetoimpact is more than a tech community; it's a family that welcomes everyone at different levels of their tech journey.<br> Be prepared to connect, learn, and grow with fellow innovators. Get ready to leveling up your future with tech! <br> <br>
                        If you have any questions or need assistance, reply to this email or contact us at <a href=\"mailto:innovatetoimpactng@gmail.com\" style=\"text-decoration: none; color: #008000; cursor:pointer\">innovatetoimpactng@gmail.com</a> <br> <br>
                        Looking forward to seeing you at the event! <br> <br>
                        P.S. Don't forget to share your registration excitement on social media using: <br> #leveluoyourfuturewithtech <br> #southeastcampustour <br> #innovatetoimpact <br>#innovate2impact <br> <br>

                        Best regards <h3>Innovatetoimpact Team<h3> <br>
                    </div>
                    ";
    
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
                    // More headers
                    $headers .= 'From: Innovatetoimpact <info@innovatetoimpact.org>' . "\r\n";

                $mail = mail($to, $subject, $message, $headers);
    
                if (!$mail) {
                    $error = "Failed to send Ticket No, please try again!";
                }else{
                    $success = true;
                    header('location: https://t.me/+6V-OlkMhN_g1ZGE0'); 
                }
                exit();
            } else {
                $error = "Registration failed, Try again";
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
        <form action="studentregister.php" method="POST" enctype="multipart/form-data" id="registrationForm" class="forms">

            <div class="form-group firstDiv" id="firstDiv">
                <label for="firstName">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter the validated mail" required>
            </div>

            <div class="form-group firstDiv" id="firstDiv">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" placeholder="Enter your first name" name="firstName" class="form-control" required>
                <div class="error" id="firstNameError">Please enter your first name</div>
            </div>

            <div class="form-group" id="lastDiv">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" class="form-control" required>
                <div class="error" id="lastNameError">Please enter your last name</div>
            </div>

            <div class="form-group" id="numberDiv">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your phone no" required>
                <div class="error" id="phoneError">Please enter a valid phone number</div>
            </div>

            <div class="form-group" id="expertiseDiv">
                <label for="expertise">Tech Expertise</label>
                <select id="expertise" name="expertise" class="form-control" required>
                    <option value="" selected disabled>Select your expertise level</option>
                    <option value="transition">I would like to transition</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="expert">Expert</option>
                </select>
                <div class="error" id="expertiseError">Please select your expertise level</div>
            </div>

            <div class="form-group" id="countryDiv">
                <label for="country">Country</label>
                <select id="country" name="country" class="form-control" required>
                      <option selected disabled>Select your country </option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Åland Islands">Åland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="America">America</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="England">England</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Helena">Saint Helena</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-leste">Timor-leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
                <div class="error" id="stateError">Please enter your contry</div>
            </div>

            <div class="form-group" id="stateDiv">
                <label for="state">State Located</label>
                <input type="text" placeholder="State of Origin" id="state" name="state" class="form-control" required>
                <div class="error" id="stateError">Please enter your state</div>
            </div>

            <div class="form-group" id="schoolDiv">
                <label for="school">Name of School</label>
                <input type="text" id="school" name="school" placeholder="School attended" class="form-control" required>
                <div class="error" id="schoolError">Please enter your school name</div>
            </div>

            <div class="form-group" id="volunteerDiv">
                <label for="volunteer">Would you like to volunteer?</label>
                <select id="volunteer" class="form-control" name="volunteer" required>
                    <option value="" selected disabled>Select an option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <div class="error" id="volunteerError">Please select an option</div>
            </div>

            <button type="submit" class="regbtn">Register</button>
        </form>
    </div>
    <script src="./js/form-validation.js"></script>
</body>

</html>