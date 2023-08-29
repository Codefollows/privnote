<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

$pdo = new PDO($dsn, $user, $pass);

$uniqueLink = $_GET['link'];

$stmt = $pdo->prepare("SELECT * FROM notes WHERE uniqueLink = :uniqueLink");
$stmt->bindParam(':uniqueLink', $uniqueLink);
$stmt->execute();

$note = $stmt->fetch(PDO::FETCH_ASSOC);

// If no note exists at all
if (!$note) {
    header('Location: index.php');
    exit;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (isset($_POST['action']) && $_POST['action'] === "reveal") {
    $content = nl2br(htmlspecialchars(decrypt($note['content'])));

    // Directly mark the note as destroyed on first reveal
    $stmt = $pdo->prepare("UPDATE notes SET destroyed_at = NOW() WHERE uniqueLink = :uniqueLink");
    $stmt->bindParam(':uniqueLink', $uniqueLink);
    $stmt->execute();
    
} elseif (isset($note['destroyed_at'])) {
    $timeElapsed = time_elapsed_string($note['destroyed_at']);
    $content = null;
} else {
    $content = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Secret Note</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">

        <?php if(isset($note['destroyed_at']) && empty($content)): ?>
        <div class="card-header bg-danger">
            Note destroyed
        </div>
        <div class="card-body">
            <p>The note with id <?php echo $uniqueLink; ?> was read and destroyed <?php echo $timeElapsed; ?>.</p>
            <p>If you haven't read this note it means someone else has. If you read it but forgot to write it down, then you need to ask whoever sent it to re-send it.</p>
        </div>

        <?php elseif(empty($content)): ?>
        <div class="card-header bg-warning">
            Are you sure you want to read this note?
        </div>
        <div class="card-body text-center">
            <form method="post" action="">
                <input type="hidden" name="action" value="reveal">
                <button type="submit" class="btn btn-primary mr-2">Show me the note</button>
                <a href="index.php" class="btn btn-secondary ml-2">No, not now</a>
            </form>
        </div>

        <?php else: ?>
        <div class="card-header bg-success">
            Note contents
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                <?php echo $content; ?>
            </div>
            <p class="text-danger mt-3">This note has been destroyed after viewing. If you need to keep it, you should have copied it before.</p>
        </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
