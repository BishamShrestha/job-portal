<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Logout - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="employer_logout.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 text-center">
        <h1 class="display-4">Logged Out</h1>
        <p>You have successfully logged out.</p>
        <a href="index.php" class="btn btn-primary">Return to Home</a>
        <br>
        <a href="employer_login.php" class="btn btn-secondary mt-2">Login Again</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
