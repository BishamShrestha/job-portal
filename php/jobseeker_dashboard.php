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

// Initialize feedback messages
$message = $error = null;

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['education'])) {
    $education = $_POST['education'];
    $photo = $_FILES['photo'];

    // Initialize variables for photo upload
    $photoPath = null;

    if (!empty($photo['name'])) {
        // Define the upload directory and file path
        $uploadDir = 'uploads/';
        $photoName = uniqid() . '_' . basename($photo['name']);
        $photoPath = $uploadDir . $photoName;

        // Move the uploaded file to the designated folder
        if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
            $photoPath = null; // Set to null if upload fails
            $error = "Error uploading photo.";
        }
    }

    // Update education and photo in the database
    $query = "UPDATE job_seeker SET education = ?, photo = IFNULL(?, photo) WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $education, $photoPath, $user_id);

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $stmt->error;
    }
}

// Fetch job applications and their statuses for the logged-in job seeker
$applications_query = "
    SELECT a.id AS application_id, j.job_title, a.status 
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    WHERE a.job_seeker_id = ?";
$stmt = $conn->prepare($applications_query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$applications_result = $stmt->get_result();

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
            <!-- Profile Update Section -->
            <div class="col-md-6">
                <h3>Update Profile</h3>
                <?php if ($message): ?>
                    <div class="alert alert-success"><?= $message; ?></div>
                <?php elseif ($error): ?>
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

            <!-- Browse Jobs Section -->
            <div class="col-md-6">
                <h3>Browse Jobs</h3>
                <a href="apply_job.php" class="btn btn-primary">Apply for Jobs</a>
            </div>
        </div>

        <!-- Application Status Section -->
        <h3 class="mt-5">Application Status</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($applications_result) && $applications_result->num_rows > 0): ?>
                    <?php while ($applications = $applications_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($applications['job_title']); ?></td>
                            <td>
                                <?php
                                $status = strtolower($applications['status']);
                                switch ($status) {
                                    case 'accepted':
                                        echo "<span class='badge badge-success'>Accepted</span>";
                                        break;
                                    case 'rejected':
                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                        break;
                                    default:
                                        echo "<span class='badge badge-warning'>Pending</span>";
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">No applications found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>