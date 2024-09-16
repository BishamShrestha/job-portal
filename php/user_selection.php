<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Selection - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="user_selection.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container text-center mt-5">
        <h1>Select Your Path</h1>
        <p class="lead">Are you a Job Seeker looking for your next opportunity or an Employer searching for talent?</p>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Job Seeker</h3>
                        <p class="card-text">Register or log in to find the perfect job for you.</p>
                        <a href="jobseeker_register.php" class="btn btn-primary">Proceed as Job Seeker</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Employer</h3>
                        <p class="card-text">Register or log in to find the best candidates for your company.</p>
                        <a href="employer_register.php" class="btn btn-secondary">Proceed as Employer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
