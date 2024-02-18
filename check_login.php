<?php
session_start();

if(isset($_POST['email']) && isset($_POST['password'])) {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "patient_db";

    $con = mysqli_connect($server, $username, $password, $database);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM patient WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 1) {
        // Login successful
        echo "success";
        exit();
    } else {
        // Login failed
        echo "error";
        exit();
    }

    mysqli_close($con);
}
?>
