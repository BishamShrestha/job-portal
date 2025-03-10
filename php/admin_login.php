<?php
session_start(); // Make sure the session is started
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password entered by admin

    // Query to get the admin credentials from the 'admin' table
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    // Check if admin exists and the password matches
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;  // Set session to indicate admin is logged in
        $_SESSION['admin_username'] = $username;  // Store the username in session

        header("Location: admin.php");  // Redirect to admin dashboard
        exit();  // Make sure to exit after the redirect to stop further execution
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center text-primary">Admin Login</h2>
        <form method="POST" class="w-50 mx-auto p-4 border rounded">
            <?php if (isset($error)) {
                echo "<p class='text-danger'>$error</p>";
            } ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</body>

</html>