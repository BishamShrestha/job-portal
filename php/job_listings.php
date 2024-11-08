<?php
session_start();
include 'db.php'; // Database connection

// Fetch job listings from the database
$jobs_query = "SELECT id, job_title, company_name, location FROM jobs";
$jobs_result = $conn->query($jobs_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="job_listings.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Listings</h1>
        <div class="list-group">
            <?php if ($jobs_result->num_rows > 0): ?>
                <?php while ($job = $jobs_result->fetch_assoc()): ?>
                    <a href="job_details.php?id=<?= htmlspecialchars($job['id']); ?>" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?= htmlspecialchars($job['job_title']); ?></h5>
                        <p class="mb-1">Company: <?= htmlspecialchars($job['company_name']); ?></p>
                        <small>Location: <?= htmlspecialchars($job['location']); ?></small>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No job listings available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
