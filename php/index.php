<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css"> <!-- Updated path -->
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
        
        <!-- Job Search Option -->
        <div class="mt-5">
            <h2>Search for Jobs</h2>
            <form action="job_search.php" method="get">
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keyword (e.g., Engineer)">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location (e.g., New York)">
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary">Search Jobs</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
