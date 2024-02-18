
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "patient_db"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $drName = $_POST['name'];
    $patientName = $_POST['patient_name'];
    $date = $_POST['date'];
    $timeSlot = $_POST['timeSlot'];
    $mode = $_POST['mode'];
    $symptoms = $_POST['symptoms'];

    // Insert appointment into database
    $sql = "INSERT INTO dr_appointment (doctor_email, patient_name, appointment_date, appointment_time, mode, symptoms) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $drName, $patientName, $date, $timeSlot, $mode, $symptoms);
    $stmt->execute();

    // Check if appointment was successfully booked
    if ($stmt->affected_rows > 0) {
        $message = "Appointment booked successfully!";
    } else {
        $message = "Failed to book appointment. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Fetch doctor names from the database
$sql = "SELECT name FROM doctor"; // Assuming your table name is 'doctors' and the column is 'name'
$result = $conn->query($sql);

// Store doctor names in an array
$doctors = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $doctors[] = $row['name'];
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<style>
    body {
        background-image: url('Image/docsBlur.jpg');
        background-size: cover;
        background-position: center;
    }
    
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 255, 0.8);
    }
</style>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="text-center my-5">
                    </div>
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4">Book Appointment</h1>
                            <?php if (isset($message)): ?>
                                <div class="alert alert-<?php echo ($message == 'Appointment booked successfully!') ? 'success' : 'danger'; ?>" role="alert">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <form method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="name">Doctor Name</label>
                                    <select class="form-select" name="name" required>
                                        <option value="">Select Doctor Name</option>
                                        <?php foreach($doctors as $doctor): ?>
                                            <option value="<?php echo $doctor; ?>"><?php echo $doctor; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Doctor Name is required
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="patient_name">Patient Name</label>
                                    <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                                    <div class="invalid-feedback">
                                        Patient Name is required
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="symptoms">Patient Symptoms</label>
                                    <textarea class="form-control" id="symptoms" name="symptoms" rows="3" required></textarea>
                                    <div class="invalid-feedback">
                                        Patient Symptoms are required
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="date">Date</label>
                                    <input id="date" type="date" class="form-control" name="date" required>
                                    <div class="invalid-feedback">
                                        Date is required
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="timeSlot">Time Slot</label>
                                    <input type="time" class="form-control" name="timeSlot" required>
                                    <div class="invalid-feedback">
                                        Time Slot is required
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="mode">Mode</label>
                                    <input type="text" class="form-control" id="mode" name="mode" required>
                                    <div class="invalid-feedback">
                                        Mode is required
                                    </div>
                                </div>
                                <p class="form-text text-muted mb-3">
                                    By Booking you agree with our terms and condition.
                                </p>
                                <hr>
                                <div class="align-items-center d-flex">
                                    <button type="submit" class="btn btn-primary ms-auto">
                                        Book
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">
                        Copyright &copy; 2017-2021 &mdash; Your Company
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
```

