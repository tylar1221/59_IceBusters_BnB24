<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the session
$email = $_SESSION['email'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "patient_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to fetch user details
$sql = "SELECT * FROM patient WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user details are found
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    // Add more fields as needed
} else {
    echo "Error: Unable to fetch user data.";
    exit();
}

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Add custom styles here */
        /* Add custom styles here */
body {
    background-color: hsl(217, 0%, 16%);
    padding: 50px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Welcome to Your Profile</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Profile Details</h5>
                <p class="card-text">Name: <?php echo $name; ?></p>
                <p class="card-text">Email: <?php echo $email; ?></p>
                <!-- Add more fields as needed -->
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
