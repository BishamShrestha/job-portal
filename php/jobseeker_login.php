<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to check the job seeker credentials
    $query = "SELECT * FROM job_seeker WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set up the session
            $_SESSION['job_seeker'] = $user;
            header('Location: jobseeker_dashboard.php'); // Redirect to job seeker dashboard
            exit();
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Login - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jobseeker_login.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header text-center">
                <h1>Job Seeker Login</h1>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error; ?>
                    </div>
                <?php endif; ?>
                <form action="jobseeker_login.php" method="post"> <!-- Corrected action -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
