<?php
session_start();
include 'db.php'; // Database connection

// Check if the job seeker is logged in
if (!isset($_SESSION['job_seeker'])) {
    // Redirect to login page if not logged in as job seeker
    header("Location: job_seeker_login.php");
    exit();
}

// Fetch jobs posted by any employer to display in the dropdown
$jobs_query = "SELECT id, job_title FROM jobs";
$jobs_result = $conn->query($jobs_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected job ID from the form
    $job_id = $_POST['job_id'];
    $applicant_name = $_SESSION['job_seeker']['name']; // Assuming job seeker's name is stored in the session
    $desired_salary = $_POST['desired_salary'];

    // Handle the uploaded file
    if (isset($_FILES['cover_letter_pdf']) && $_FILES['cover_letter_pdf']['error'] == 0) {
        // Set the upload directory
        $upload_dir = 'uploads/';

        // Create the directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Get the file details
        $file_name = basename($_FILES['cover_letter_pdf']['name']);
        $target_file = $upload_dir . $file_name;

        // Check if the file is a PDF
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($file_type != 'pdf') {
            echo "<div class='alert alert-danger'>Only PDF files are allowed!</div>";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['cover_letter_pdf']['tmp_name'], $target_file)) {
                // Insert application details into the database
                $insert_query = "
                    INSERT INTO applications (job_id, applicant_name, cover_letter, desired_salary, status) 
                    VALUES (?, ?, ?, ?, 'Pending')";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param('isss', $job_id, $applicant_name, $file_name, $desired_salary);
                
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Application submitted successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>There was an error submitting your application.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>There was an error uploading your file.</div>";
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
    <title>Apply for Job - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/apply_job.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Apply for Job</h1>
        <form action="apply_job.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="job_id">Select Job</label>
                <select class="form-control" id="job_id" name="job_id" required>
                    <option value="">Select a job</option>
                    <?php if ($jobs_result->num_rows > 0): ?>
                        <?php while ($job = $jobs_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($job['id']); ?>"><?= htmlspecialchars($job['job_title']); ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No jobs available</option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cover_letter_pdf">Upload Cover Letter (PDF)</label>
                <input type="file" class="form-control-file" id="cover_letter_pdf" name="cover_letter_pdf" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="desired_salary">Desired Salary</label>
                <input type="text" class="form-control" id="desired_salary" name="desired_salary" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
