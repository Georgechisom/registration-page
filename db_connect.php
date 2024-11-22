<?php

$con = new mysqli('localhost', 'root', '', 'innovate-to-impact');

if (!$con) {
    die(mysqli_error($con));
};

