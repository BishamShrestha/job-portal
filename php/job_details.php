<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="job_details.css">
</head>

<body>
    <?php
    include 'navbar.php';
    include 'db.php'; // Database connection file
    
    // Get the job ID from the URL
    if (isset($_GET['id'])) {
        $job_id = $_GET['id'];

        // Prepare the SQL query to fetch job details
        $query = "SELECT * FROM jobs WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the job exists
        if ($result->num_rows > 0) {
            $job = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger'>Job not found.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>No job ID specified.</div>";
        exit;
    }
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Details</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($job['job_title']); ?></h2>
                <h5 class="card-subtitle mb-2 text-muted">Company: <?= htmlspecialchars($job['company_name']); ?></h5>
                <p class="card-text">Location: <?= htmlspecialchars($job['location']); ?></p>
                <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($job['description']); ?></p>
                <p class="card-text"><strong>Salary:</strong> <?= htmlspecialchars($job['salary']); ?></p>
                <p class="card-text"><strong>Benefits:</strong> <?= htmlspecialchars($job['benefits']); ?></p>
                <p class="card-text"><strong>Application Deadline:</strong> <?= htmlspecialchars($job['deadline']); ?>
                </p>
                <a href="apply_job.php?id=<?= $job['id']; ?>" class="btn btn-primary">Apply Now</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>