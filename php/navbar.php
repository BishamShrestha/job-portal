<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Navbar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Job Portal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

                <?php if (isset($_SESSION['job_seeker'])): ?>
                    <!-- Job Seeker Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="jobSeekerDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Job Seeker
                        </a>
                        <div class="dropdown-menu" aria-labelledby="jobSeekerDropdown">
                            <a class="dropdown-item" href="jobseeker_logout.php">Logout</a>
                        </div>
                    </li>
                <?php elseif (isset($_SESSION['employer'])): ?>
                    <!-- Employer Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="employerDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Employer
                        </a>
                        <div class="dropdown-menu" aria-labelledby="employerDropdown">
                            <a class="dropdown-item" href="employer_logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Job Seeker and Employer Login Options if not logged in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="jobSeekerDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Job Seeker
                        </a>
                        <div class="dropdown-menu" aria-labelledby="jobSeekerDropdown">
                            <a class="dropdown-item" href="jobseeker_login.php">Login</a>
                            <a class="dropdown-item" href="jobseeker_register.php">Register</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="employerDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Employer
                        </a>
                        <div class="dropdown-menu" aria-labelledby="employerDropdown">
                            <a class="dropdown-item" href="employer_login.php">Login</a>
                            <a class="dropdown-item" href="employer_register.php">Register</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>