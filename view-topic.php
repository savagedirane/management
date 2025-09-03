<?php
include 'auth.php';
include 'db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: forum.php');
    exit;
}
$topic_id = intval($_GET['id']);
// Fetch topic
$topic_sql = "SELECT t.*, u.username FROM forum_topics t LEFT JOIN users u ON t.user_id=u.id WHERE t.id=$topic_id";
$topic = $conn->query($topic_sql)->fetch_assoc();
if (!$topic) {
    echo '<div class="container py-4"><div class="alert alert-danger">Topic not found.</div></div>';
    exit;
}
// Handle new comment
if (isset($_POST['add_comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO forum_comments (topic_id, user_id, comment) VALUES ($topic_id, $user_id, '$comment')";
    if ($conn->query($sql)) {
        echo '<div class="container py-2"><div class="alert alert-success">Comment added!</div></div>';
    } else {
        echo '<div class="container py-2"><div class="alert alert-danger">Error adding comment.</div></div>';
    }
}
// Fetch comments
$comments = $conn->query("SELECT c.*, u.username FROM forum_comments c LEFT JOIN users u ON c.user_id=u.id WHERE c.topic_id=$topic_id ORDER BY c.created_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Topic - School Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-success"><?php echo htmlspecialchars($topic['title']); ?></h3>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($topic['content'])); ?></p>
            <div class="text-muted small">By <?php echo htmlspecialchars($topic['username']); ?> on <?php echo date('d M Y H:i', strtotime($topic['created_at'])); ?></div>
        </div>
    </div>
    <h5 class="mb-3">Comments</h5>
    <?php while ($comment = $comments->fetch_assoc()): ?>
    <div class="card mb-2">
        <div class="card-body">
            <div class="text-muted small mb-1">By <?php echo htmlspecialchars($comment['username']); ?> on <?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?></div>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
        </div>
    </div>
    <?php endwhile; ?>
    <form method="POST" class="card card-body shadow-sm mt-4">
        <h6>Add a Comment</h6>
        <textarea name="comment" class="form-control mb-2" rows="2" placeholder="Write your comment..." required></textarea>
        <button type="submit" name="add_comment" class="btn btn-primary">Post Comment</button>
    </form>
    <a href="forum.php" class="btn btn-link mt-3">&larr; Back to Forum</a>
</div>
</body>
</html>
