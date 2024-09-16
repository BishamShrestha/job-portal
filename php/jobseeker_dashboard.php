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
            <div class="col-md-6">
                <h3>Update Profile</h3>
                <form action="update_profile_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" class="form-control" id="education" name="education">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control-file" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Browse Jobs</h3>
                <!-- Job listing goes here -->
                <a href="apply_job.php" class="btn btn-primary">Apply for Jobs</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
