<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container text-center mt-5">
        <h1>Welcome to the Job Portal</h1>
        <p class="lead">Find your dream job or the perfect candidate with ease.</p>
        <hr class="my-4">
        <p>Whether you're a job seeker or an employer, we've got you covered. Register or log in to get started!</p>
        <div class="mt-4">
            <a class="btn btn-primary btn-lg mb-2" href="jobseeker_register.php" role="button">Job Seeker Register</a>
            <a class="btn btn-secondary btn-lg mb-2" href="employer_register.php" role="button">Employer Register</a>
        </div>
    </div>

    <!-- Job Cards Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Featured Jobs</h2>
        <div class="row">

            <?php
            // Database connection
            include 'db.php';

            // Fetch jobs from the database (limit to 4 jobs for display)
            $jobs_query = "SELECT id, job_title, company, location, salary, benefits 
                           FROM jobs
                           LIMIT 4";
            $result = $conn->query($jobs_query);

            if ($result->num_rows > 0) {
                // Loop through and display each job in a card
                while ($job = $result->fetch_assoc()) {
                    echo '
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($job['job_title']) . '</h5>
                                    <p class="card-text"><strong>Company:</strong> ' . htmlspecialchars($job['company']) . '</p>
                                    <p class="card-text"><strong>Location:</strong> ' . htmlspecialchars($job['location']) . '</p>
                                    <p class="card-text"><strong>Salary:</strong> ' . htmlspecialchars($job['salary']) . '</p>
                                </div>
                            </div>
                        </div>
                    ';
                }
            } else {
                echo '<p>No jobs available at the moment.</p>';
            }
            ?>

        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>