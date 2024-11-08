<?php
session_start();
include 'db.php'; // Database connection

// Check if the form is submitted
$alertMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $alertMessage = "<div class='alert alert-success'>Your message has been sent successfully!</div>";
    } else {
        $alertMessage = "<div class='alert alert-danger'>There was an error sending your message. Please try again.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <!-- Display success or error message if set -->
        <?php if (!empty($alertMessage)) echo $alertMessage; ?>

        <div class="row">
            <!-- Contact Information Section -->
            <div class="col-md-6">
                <h3>Contact Information</h3>
                <p>Feel free to reach out to us via any of the following contact methods:</p>
                <ul class="list-unstyled">
                    <li><strong>Email:</strong> <a href="mailto:info@jobportal.com">info@jobportal.com</a></li>
                    <li><strong>Website:</strong> <a href="https://www.jobportal.com" target="_blank">www.jobportal.com</a></li>
                    <li><strong>Phone Number:</strong> 01-660203</li>
                    <li><strong>Address:</strong> Balkot Tole, Bhaktapur, Nepal</li>
                </ul>
            </div>

            <!-- Contact Form Section -->
            <div class="col-md-6">
                <h3>Send Us a Message</h3>
                <form action="contact.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
