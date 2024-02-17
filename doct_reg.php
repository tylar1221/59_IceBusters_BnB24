<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection (replace with your credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "patient_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $date = $_POST['date'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $license = $_POST['license'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];

    // Perform server-side validation (you can add more validation as needed)
    if (empty($name) || empty($gender) || empty($date) || empty($email) || empty($number) || empty($license) || empty($specialization) || empty($experience)) {
        $error_message = "All fields are required";
    } else {
        // Prepare and execute SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO `doctor` (`name`, `gender`, `date`, `email`, `number`, `license`, `specialization`, `certificates`, `experience`, `photo`) VALUES (?, ?, ?, ?, ?, ?, ?, '', ?, '');");
        $stmt->bind_param("ssssssss", $name, $gender, $date, $email, $number, $license, $specialization, $experience);

        if ($stmt->execute()) {
            $success_message = "Doctor registered successfully";
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="This is a login page template based on Bootstrap 5">
    <title>Doctor Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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
            height: 200%;
            background-color: rgba(0, 0, 255, 0.8); 
        }

        .container{
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                   
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4">Doctor Registration</h1>
                            <?php if (isset($success_message)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $success_message; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($error_message)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" class="needs-validation" novalidate="" autocomplete="off" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="name">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required autofocus>
                                    <div class="invalid-feedback">
                                        Name is required    
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="gender">Gender</label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Gender is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="dob">Date of Birth</label>
                                    <input id="date" type="date" class="form-control" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>" required>
                                    <div class="invalid-feedback">
                                        Date of Birth is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="email">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                                    <div class="invalid-feedback">
                                        Email is invalid
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="number">Phone Number</label>
                                    <input id="number" type="text" class="form-control" name="number" value="<?php echo isset($_POST['number']) ? $_POST['number'] : ''; ?>" required>
                                    <div class="invalid-feedback">
                                        Phone Number is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="license">License Number</label>
                                    <input id="license" type="text" class="form-control" name="license" required>
                                    <div class="invalid-feedback">
                                        License Number is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="specialization">Specialization</label>
                                    <input id="specialization" type="text" class="form-control" name="specialization" required>
                                    <div class="invalid-feedback">
                                        Specialization is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="experience">Experience</label>
                                    <input id="experience" type="text" class="form-control" name="experience" required>
                                    <div class="invalid-feedback">
                                        Experience is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="certificate">Certificate (PDF)</label>
                                    <input id="certificate" type="file" class="form-control" name="certificate" accept="application/pdf" required>
                                    <div class="invalid-feedback">
                                        Certificate is required
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-2 text-muted" for="photo">Photo</label>
                                    <input id="photo" type="file" class="form-control" name="photo" accept="image/jpeg, image/png" required>
                                    <div class="invalid-feedback">
                                        Photo is required
                                    </div>
                                </div>


                                <p class="form-text text-muted mb-3">
                                    By registering you agree with our terms and condition.
                                </p>

                                <div class="align-items-center d-flex">
                                <a href="http://localhost/LOGINp/59_IceBusters_BnB24/index.html" class="btn btn-primary ms-auto">Register</a>

                                </div>
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Already have an account? <a href="http://localhost/LOGINp/59_IceBusters_BnB24/doct_reg.php" class="text-dark">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">
                        Copyright &copy; 2017-2021 &mdash; Your Company 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/login.js"></script>
</body>
</html>
