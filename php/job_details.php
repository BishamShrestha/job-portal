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
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Details</h1>
        <!-- Example job details -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Software Engineer</h2>
                <h5 class="card-subtitle mb-2 text-muted">Company: Tech Solutions</h5>
                <p class="card-text">Location: New York, NY</p>
                <p class="card-text"><strong>Description:</strong> We are looking for a skilled Software Engineer to join our team...</p>
                <p class="card-text"><strong>Salary:</strong> $80,000 - $100,000 per year</p>
                <p class="card-text"><strong>Benefits:</strong> Health insurance, 401k, Paid time off</p>
                <p class="card-text"><strong>Application Deadline:</strong> September 30, 2024</p>
                <a href="apply_job.php" class="btn btn-primary">Apply Now</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
