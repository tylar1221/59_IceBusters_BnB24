<?php
// Initialize variables
$email = "";
$verificationCode = "";
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is submitted
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        // Generate a random verification code
        $verificationCode = rand(100000, 999999);
        // Here you should send the verification code to the user's email
        // For simplicity, we'll just output it
        echo "Verification code sent to $email: $verificationCode";
    } elseif (isset($_POST["code"])) { // Check if verification code is submitted
        // Validate the verification code (You should validate against the sent code)
        $submittedCode = $_POST["code"];
        // For simplicity, we'll just compare it with the generated code
        if ($submittedCode == $verificationCode) {
            // Verification successful, allow the user to set a new password
            echo "Verification successful. Set a new password here.";
            // You can include a form to set a new password here
        } else {
            $errorMessage = "Invalid verification code. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Forgot Password
                    </div>
                    <div class="card-body">
                        <?php if (empty($verificationCode)) { ?>
                            <!-- Display email input form -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Verification Code</button>
                            </form>
                        <?php } else { ?>
                            <!-- Display verification code input form -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                                <?php if (!empty($errorMessage)) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $errorMessage; ?>
                                    </div>
                                <?php } ?>
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
