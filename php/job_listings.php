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
            <!-- Example job listing -->
            <a href="job_details.php?id=1" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Software Engineer</h5>
                <p class="mb-1">Company: Tech Solutions</p>
                <small>Location: New York, NY</small>
            </a>
            <!-- Repeat the above block for each job listing -->
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
