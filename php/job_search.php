<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - Job Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/job_search.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Job Search</h1>
        <form action="search_results.php" method="get">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="keyword">Keyword</label>
                    <input type="text" class="form-control" id="keyword" name="keyword"
                        placeholder="e.g., Software Engineer">
                </div>
                <div class="form-group col-md-4">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g., New York">
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>