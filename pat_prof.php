<?php
// Start session to access session variables
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_email'])) {
    header("Location: http://localhost/LOGINp/login.php");
    exit();
}

$servername = "localhost"; // Change this to your database server name if it's different
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password if you have one
$database = "patient_db"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user data based on user type (patient)
$email = $_SESSION['email'];

if ($user_type == "patient") {
    $sql = "SELECT * FROM patient WHERE email = '$user_email'";
} else {
    // Redirect other user types to an appropriate page or display an error
    header("Location: error.php");
    exit();
}

$result = mysqli_query($conn, $sql);

// Check if data was fetched successfully
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Extract user data
    $name = $row['name'];
    $email = $row['email'];
    // Add more fields as needed
} else {
    echo "Error: Unable to fetch user data.";
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>Welcome to Your Profile</h1>
    <p>Name: <?php echo $name; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <!-- Add more fields as needed -->
    <a href="logout.php">Logout</a>
</body>
</html>
