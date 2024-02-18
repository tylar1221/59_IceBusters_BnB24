<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to the login page
    header("Location: doct_log.php");
    exit();
}

// Establish connection to the database
$server = "localhost";
$username = "root";
$password = "";
$database = "patient_db";

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve doctor's information from the database
$email = $_SESSION['email'];
$sql_doctor = "SELECT * FROM doctor WHERE email=?";
$stmt_doctor = $conn->prepare($sql_doctor);
$stmt_doctor->bind_param("s", $email);
$stmt_doctor->execute();
$result_doctor = $stmt_doctor->get_result();

if ($result_doctor->num_rows == 1) {
    $row_doctor = $result_doctor->fetch_assoc();
    $name = $row_doctor['name'];
    $specialization = $row_doctor['specialization'];
    $experience = $row_doctor['experience'];
    $photo = $row_doctor['photo'];
} else {
    echo "Doctor not found";
    exit();
}

// Fetch appointments for the logged-in doctor
$sql_appointments = "SELECT * FROM dr_appointment WHERE doctor_email=?";
$stmt_appointments = $conn->prepare($sql_appointments);
$stmt_appointments->bind_param("s", $email);
$stmt_appointments->execute();
$result_appointments = $stmt_appointments->get_result();

$appointments = array();
while ($row_appointment = $result_appointments->fetch_assoc()) {
    $appointments[] = $row_appointment;
}

$stmt_doctor->close();
$stmt_appointments->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <style>
        body {
            background-color: blue; /* Light gray background color */
            color: #333; /* Dark text color */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Specify font family */
            text-align: center; /* Center-align text */
            margin: 0;
            padding: 0;
        }

        h1 {
            margin-top: 20px; /* Add some space above the heading */
        }

        .btn-photo {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000; /* Ensure the button appears above other elements */
        }

        .profile-container {
            background-color: #fff; /* White background for profile container */
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Center the container horizontally */
            max-width: 600px; /* Limit profile container width */
        }

        .profile-container img {
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .profile-details {
            margin-top: 20px;
        }

        .profile-details p {
            margin-bottom: 10px;
        }

        .profile-details strong {
            font-weight: bold;
            margin-right: 5px;
        }

        .appointment-container {
            background-color: #fff; /* White background for appointment container */
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Center the container horizontally */
            max-width: 600px; /* Limit appointment container width */
        }

        .appointment-container h2 {
            text-align: center; /* Center-align heading */
            margin-bottom: 20px;
        }

        .appointment-list {
            list-style: none;
            padding: 0;
        }

        .appointment-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <a href="index.html" class="btn-photo">
        <button class="btn btn-primary">Button</button>
    </a>
    <h1>Welcome to Your Doctor Profile Page</h1>
    <div class="profile-container">
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Specialization:</strong> <?php echo $specialization; ?></p>
            <p><strong>Experience:</strong> <?php echo $experience; ?></p>
        </div>
    </div>
    <div class="appointment-container">
        <h2>Upcoming Appointments</h2>
        <ul class="appointment-list">
            <?php foreach ($appointments as $appointment): ?>
                <li class="appointment-item">
                    <?php echo "Patient: " . $appointment['patient_name'] . " - Date: " . $appointment['appointment_date'] . " - Time: " . $appointment['appointment_time'] . " - Mode: " . $appointment['mode']." - Symptoms: ".$appointment['symptoms']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
