<?php
session_start();  // Start session at the top of the page

// Include the database connection
include('db.php');

// Redirect to login page if admin is not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");  // Redirect to the login page if not logged in
    exit();  // Stop execution of the rest of the script
}

// Get admin username from the session
$admin_username = $_SESSION['admin_username'];

// Make sure to define $current_date before using it
date_default_timezone_set("Asia/Kathmandu"); // Set your timezone for Nepal
$current_date = date("Y-m-d"); // Now it's always defined

// Delete jobs where the deadline has passed
$delete_query = "DELETE FROM jobs WHERE deadline < '$current_date'";
mysqli_query($conn, $delete_query);

// Fetch all jobseekers
$jobseekers_query = "SELECT * FROM job_seeker";
$jobseekers_result = mysqli_query($conn, $jobseekers_query);

// Fetch all employers
$employers_query = "SELECT * FROM employer";
$employers_result = mysqli_query($conn, $employers_query);

// Fetch all jobs
$jobs_query = "SELECT * FROM jobs";
$jobs_result = mysqli_query($conn, $jobs_query);

// Fetch all contact messages
$contact_messages_query = "SELECT * FROM contact_messages";
$contact_messages_result = mysqli_query($conn, $contact_messages_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        h1,
        h2 {
            color: #007bff;
            text-align: center;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome, <?php echo $admin_username; ?>!</h1>
        <a href="logout.php" class="btn btn-danger float-right">Logout</a>

        <!-- Job Seekers List -->
        <h2>Job Seekers</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($jobseeker = mysqli_fetch_assoc($jobseekers_result)) { ?>
                    <tr>
                        <td><?php echo $jobseeker['id']; ?></td>
                        <td><?php echo $jobseeker['name']; ?></td>
                        <td><?php echo $jobseeker['email']; ?></td>
                        <td><?php echo $jobseeker['phone_number']; ?></td>
                        <td><a href="admin.php?delete_jobseeker=<?php echo $jobseeker['id']; ?>" class="btn btn-danger"
                                onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Employers List -->
        <h2>Employers</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($employer = mysqli_fetch_assoc($employers_result)) { ?>
                    <tr>
                        <td><?php echo $employer['id']; ?></td>
                        <td><?php echo $employer['email']; ?></td>
                        <td><?php echo $employer['phone_number']; ?></td>
                        <td><a href="?delete_employer=<?php echo $employer['id']; ?>" class="btn-delete"
                                onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Jobs List -->
        <h2>Jobs</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employer ID</th>
                    <th>Job Title</th>
                    <th>Description</th>
                    <th>Salary</th>
                    <th>Benefits</th>
                    <th>Deadline</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = mysqli_fetch_assoc($jobs_result)) { ?>
                    <tr>
                        <td><?php echo $job['id']; ?></td>
                        <td><?php echo $job['employer_id']; ?></td>
                        <td><?php echo $job['job_title']; ?></td>
                        <td><?php echo $job['description']; ?></td>
                        <td><?php echo $job['salary']; ?></td>
                        <td><?php echo $job['benefits']; ?></td>
                        <td><?php echo $job['deadline']; ?></td>
                        <td><?php echo $job['company']; ?></td>
                        <td><?php echo $job['location']; ?></td>
                        <td>
                            <a href="?delete_job=<?php echo $job['id']; ?>" class="btn-delete"
                                onclick="return confirmDelete();">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Contact Messages List -->
        <h2>Contact Us Messages</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($message = mysqli_fetch_assoc($contact_messages_result)) { ?>
                    <tr>
                        <td><?php echo $message['id']; ?></td>
                        <td><?php echo $message['name']; ?></td>
                        <td><?php echo $message['email']; ?></td>
                        <td><?php echo $message['message']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <script>
        // JavaScript function to confirm delete action
        function confirmDelete() {
            return confirm("Are you sure you want to delete this item?");
        }
    </script>

</body>

</html>