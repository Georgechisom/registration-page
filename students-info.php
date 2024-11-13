<?php
// Include database connection
include 'db_connect.php';

// Fetch data from the registrations table
$query = "SELECT * FROM `registrations`";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    // Start HTML output
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Registration Data</title>
        <link rel='stylesheet' href='./css/table.css'> <!-- Optional: Link to your CSS -->
    </head>
    <body>
        <div class='container'>
            <table border='1'>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>School</th>
                        <th>Expertise</th>
                        <th>Volunteer</th>
                        <th>OTP</th>
                    </tr>
                </thead>
                <tbody>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['country']}</td>
                <td>{$row['state']}</td>
                <td>{$row['school']}</td>
                <td>{$row['expertise']}</td>
                <td>{$row['volunteer']}</td>
                <td>{$row['OTP']}</td>
              </tr>";
    }

    echo "    </tbody>
            </table>
        </div>
    </body>
    </html>";
} else {
    echo "No data found.";
}

// Close the database connection
$con->close();
