<?php
include 'auth.php';
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="mb-4 text-primary">School Forum</h2>
    <div class="mb-4">
        <form method="POST" class="card card-body shadow-sm mb-3">
            <h5 class="mb-3">Start a New Topic</h5>
            <input type="text" name="title" class="form-control mb-2" placeholder="Topic Title" required>
            <textarea name="content" class="form-control mb-2" placeholder="Describe your topic..." rows="3" required></textarea>
            <button type="submit" name="post_topic" class="btn btn-success">Post Topic</button>
        </form>
        <?php
        if (isset($_POST['post_topic'])) {
            $title = $conn->real_escape_string($_POST['title']);
            $content = $conn->real_escape_string($_POST['content']);
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO forum_topics (user_id, title, content) VALUES ($user_id, '$title', '$content')";
            if ($conn->query($sql)) {
                echo '<div class="alert alert-success">Topic posted!</div>';
            } else {
                echo '<div class="alert alert-danger">Error posting topic.</div>';
            }
        }
        ?>
    </div>
    <h4 class="mb-3">Recent Topics</h4>
    <?php
    $topics = $conn->query("SELECT t.*, u.username FROM forum_topics t LEFT JOIN users u ON t.user_id=u.id ORDER BY t.created_at DESC LIMIT 10");
    while ($topic = $topics->fetch_assoc()):
    ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-success"><?php echo htmlspecialchars($topic['title']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($topic['content'])); ?></p>
            <div class="text-muted small">By <?php echo htmlspecialchars($topic['username']); ?> on <?php echo date('d M Y H:i', strtotime($topic['created_at'])); ?></div>
            <a href="view-topic.php?id=<?php echo $topic['id']; ?>" class="btn btn-outline-primary btn-sm mt-2">View & Comment</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>
</body>
</html>
