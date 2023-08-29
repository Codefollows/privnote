<?php
include 'config.php';

$pdo = new PDO($dsn, $user, $pass);

$encryptedContent = encrypt($_POST['content']);

$uniqueLink = uniqid();

$stmt = $pdo->prepare("INSERT INTO notes (uniqueLink, content) VALUES (:uniqueLink, :content)");
$stmt->bindParam(':uniqueLink', $uniqueLink);
$stmt->bindParam(':content', $encryptedContent);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Note Link</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header bg-primary text-white">
                Your Self-Destructive Note Link
            </div>
            <div class="card-body text-center">
                <p>Share this link with the recipient. The note will be destroyed once read:</p>
                <a href="note.php?link=<?php echo $uniqueLink; ?>" target="_blank">https://rebirth-ps.net/notes/note.php?link=<?php echo $uniqueLink; ?></a>
            </div>
        </div>
    </div>
</body>
</html>
