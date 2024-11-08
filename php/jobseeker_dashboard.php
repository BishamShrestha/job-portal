<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['job_seeker'])) {
    header('Location: jobseeker_login.php'); // Redirect to login if not logged in
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['job_seeker']['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $education = $_POST['education'];
    $photo = $_FILES['photo'];

    // Initialize variables for photo upload
    $photoPath = null;

    if ($photo['error'] == UPLOAD_ERR_OK) {
        // Define the upload directory and file path
        $uploadDir = 'uploads/';
        $photoName = uniqid() . '_' . basename($photo['name']);
        $photoPath = $uploadDir . $photoName;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
            $photoPath = null; // Set to null if upload fails
        }
    }

    // Prepare the SQL statement to update the user's education and photo
    $query = "UPDATE job_seeker SET education = ?, photo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $education, $photoPath, $user_id);

    if ($stmt->execute()) {
        // Update was successful
        $message = "Profile updated successfully!";
    } else {
        // Update failed
        $error = "Error updating profile: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="jobseeker_dashboard.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Seeker Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Update Profile</h3>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success"><?= $message; ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php endif; ?>
                <form action="jobseeker_dashboard.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" class="form-control" id="education" name="education" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Browse Jobs</h3>
                <!-- Job listing goes here -->
                <a href="apply_job.php" class="btn btn-primary">Apply for Jobs</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
