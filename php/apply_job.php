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
        <form action="apply_job_action.php" method="post">
            <div class="form-group">
                <label for="cover_letter">Cover Letter</label>
                <textarea class="form-control" id="cover_letter" name="cover_letter" rows="4" required></textarea>
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
