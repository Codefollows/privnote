<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleNote</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            Create a Self-Destructive Note
        </div>
        <div class="card-body">
            <form action="submit.php" method="post">
                <textarea name="content" class="form-control" rows="8" required placeholder="Write your note here..."></textarea>
                <button type="submit" class="btn btn-success mt-3">Create Note</button>
            </form>
        </div>
    </div>
</div>

<!-- Footer Section -->
<footer class="footer bg-dark text-white mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-3 mb-3">
                <a href="index.php" class="text-white">Write a new note</a> |
                <a href="support.php" class="text-white ml-2">Support</a> |
                <a href="privacy.php" class="text-white ml-2">Privacy</a> |
                <a href="about.php" class="text-white ml-2">About</a>
            </div>
            <div class="col-md-6 mt-3 mb-3 text-right">
                <a href="https://blog.yourdomain.com" class="text-white mr-2">Blog</a>
                <a href="https://twitter.com/" target="_blank" class="text-white mr-2"><i class="fab fa-twitter"></i></a>
                <a href="https://facebook.com/" target="_blank" class="text-white"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
