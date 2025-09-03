<?php
include 'auth.php';
include 'db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: blog.php');
    exit;
}
$post_id = intval($_GET['id']);
// Fetch post
$post_sql = "SELECT p.*, u.username FROM blog_posts p LEFT JOIN users u ON p.user_id=u.id WHERE p.id=$post_id";
$post = $conn->query($post_sql)->fetch_assoc();
if (!$post) {
    echo '<div class="container py-4"><div class="alert alert-danger">Article not found.</div></div>';
    exit;
}
// Handle new comment
if (isset($_POST['add_comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO blog_comments (post_id, user_id, comment) VALUES ($post_id, $user_id, '$comment')";
    if ($conn->query($sql)) {
        echo '<div class="container py-2"><div class="alert alert-success">Comment added!</div></div>';
    } else {
        echo '<div class="container py-2"><div class="alert alert-danger">Error adding comment.</div></div>';
    }
}
// Fetch comments
$comments = $conn->query("SELECT c.*, u.username FROM blog_comments c LEFT JOIN users u ON c.user_id=u.id WHERE c.post_id=$post_id ORDER BY c.created_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Article - School Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-info"><?php echo htmlspecialchars($post['title']); ?></h3>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <div class="text-muted small">By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('d M Y H:i', strtotime($post['created_at'])); ?></div>
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
        <button type="submit" name="add_comment" class="btn btn-info">Post Comment</button>
    </form>
    <a href="blog.php" class="btn btn-link mt-3">&larr; Back to Blog</a>
</div>
</body>
</html>
