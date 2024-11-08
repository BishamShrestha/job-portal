<?php
session_start();
include 'db.php'; // Database connection

// Check if the profile update form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_name']) && isset($_POST['address'])) {
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];

    // Update the company table with the new company name and address (location)
    $update_company_query = "UPDATE company SET company_name = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($update_company_query);
    $stmt->bind_param('ssi', $company_name, $address, $_SESSION['employer']['id']);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating profile. Please try again.</div>";
    }
}

// Check if the form for posting a new job has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_title'])) {
    // Retrieve the employer's ID from the session
    $employer_id = $_SESSION['employer']['id'];
    
    // Get job details from the form submission
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $benefits = $_POST['benefits'];
    $deadline = $_POST['deadline'];

    // Insert the job details into the jobs table
    $insert_job_query = "
        INSERT INTO jobs (employer_id, job_title, description, salary, benefits, deadline) 
        VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_job_query);
    $stmt->bind_param('isssss', $employer_id, $job_title, $description, $salary, $benefits, $deadline);

    // Check if the insertion was successful
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Job posted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error posting job. Please try again.</div>";
    }
}

// Fetch jobs posted by the employer to display in the dropdown for filtering applications
$jobs_query = "SELECT id, job_title FROM jobs WHERE employer_id = ?";
$stmt = $conn->prepare($jobs_query);
$stmt->bind_param('i', $_SESSION['employer']['id']);
$stmt->execute();
$jobs_result = $stmt->get_result();

// Handle filtering applications based on selected job
$selected_job_id = null;
if (isset($_POST['job_id'])) {
    $selected_job_id = $_POST['job_id'];
}

// Fetch job applications related to the employer and filtered by job
$applications_query = "
    SELECT a.*, j.job_title 
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    WHERE j.employer_id = ?" . ($selected_job_id ? " AND a.job_id = ?" : "");
$stmt = $conn->prepare($applications_query);
if ($selected_job_id) {
    $stmt->bind_param('ii', $_SESSION['employer']['id'], $selected_job_id);
} else {
    $stmt->bind_param('i', $_SESSION['employer']['id']);
}
$stmt->execute();
$applications_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/employer_dashboard.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Employer Dashboard</h1>
        <div class="row">
            <!-- Profile Update Section -->
            <div class="col-md-6">
                <h3>Manage Company Profile</h3>
                <form action="employer_dashboard.php" method="post">
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <!-- Post Job Section -->
            <div class="col-md-6">
                <h3>Post New Job</h3>
                <form action="employer_dashboard.php" method="post">
                    <div class="form-group">
                        <label for="job_title">Job Title</label>
                        <input type="text" class="form-control" id="job_title" name="job_title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" id="salary" name="salary" required>
                    </div>
                    <div class="form-group">
                        <label for="benefits">Benefits</label>
                        <textarea class="form-control" id="benefits" name="benefits" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="deadline">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Job</button>
                </form>
            </div>
        </div>

        <!-- View Applications Section -->
        <h3 class="mt-5">View Applications</h3>
        <form method="post" action="">
            <div class="form-group">
                <label for="job_id">Select Job</label>
                <select class="form-control" id="job_id" name="job_id" onchange="this.form.submit()">
                    <option value="">All Jobs</option>
                    <?php while ($job = $jobs_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($job['id']); ?>" <?= ($selected_job_id == $job['id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($job['job_title']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Applicant Name</th>
                    <th>Cover Letter</th>
                    <th>Desired Salary</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($applications_result->num_rows > 0): ?>
                    <?php while ($application = $applications_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($application['job_title']); ?></td>
                            <td><?= htmlspecialchars($application['applicant_name']); ?></td>
                            <td><a href="uploads/<?= htmlspecialchars($application['cover_letter']); ?>" target="_blank">View</a></td>
                            <td><?= htmlspecialchars($application['desired_salary']); ?></td>
                            <td><?= htmlspecialchars($application['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No applications found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
