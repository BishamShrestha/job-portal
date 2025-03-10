<?php
include 'db.php'; // Database connection

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Build th\e SQL query with placeholders
$query = "SELECT * FROM jobs WHERE 1=1"; // Use WHERE 1=1 to simplify adding conditions
$params = [];
$types = '';

// Add keyword filter if provided
if (!empty($keyword)) {
    $query .= " AND job_title LIKE ?";
    $params[] = "%$keyword%";
    $types .= 's';
}

// Add location filter if provided
// Assuming the correct column name in the database is job_location
if (!empty($location)) {
    $query .= " AND job_location LIKE ?";
    $params[] = "%$location%";
    $types .= 's';
}

// Add category filter if provided
if (!empty($category) && $category != "Choose...") {
    $query .= " AND job_category = ?";
    $params[] = $category;
    $types .= 's';
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/job_search.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Search Results</h1>
        <div class="list-group">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($job = $result->fetch_assoc()): ?>
                    <a href="job_details.php?id=<?= htmlspecialchars($job['id']); ?>"
                        class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?= htmlspecialchars($job['job_title']); ?></h5>
                        <p class="mb-1">Company: <?= htmlspecialchars($job['company_name']); ?></p>
                        <small>Location: <?= htmlspecialchars($job['job_location']); ?></small>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No jobs found for your search criteria.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>