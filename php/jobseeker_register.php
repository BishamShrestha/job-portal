<?php
session_start();
include 'db.php'; // Ensure this is the correct path to your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $education = $_POST['education'];

    // Validate password strength on the server side
    $password_requirements = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($password_requirements, $password)) {
        $error = "Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle file upload for the photo
        $photo_path = null;
       // Ensure the uploads directory exists
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Creates the directory with permissions
}

$target_file = $target_dir . uniqid() . "_" . basename($_FILES['photo']['name']);

if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
    $photo_path = $target_file;
} else {
    $error = "Failed to upload photo.";
}


        if (!isset($error)) {
            // Insert job seeker data into the database
            $query = "INSERT INTO job_seeker (name, address, email, phone_number, password, education, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssss", $name, $address, $email, $phone, $hashed_password, $education, $photo_path);

            if ($stmt->execute()) {
                // Registration successful, redirect to the login page
                header('Location: jobseeker_login.php');
                exit();
            } else {
                $error = "Error: Could not register job seeker.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Registration - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jobseeker_register.css">
    <style>
        .password-requirements {
            color: red;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header text-center">
                <h2>Job Seeker Registration</h2>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>
                
                <form action="" method="post" enctype="multipart/form-data" onsubmit="return validatePassword()">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <small class="password-requirements" id="password-requirements">
                            Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" class="form-control" id="education" name="education" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function validatePassword() {
            var password = document.getElementById('password').value;
            var requirements = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            
            if (!requirements.test(password)) {
                alert('Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
