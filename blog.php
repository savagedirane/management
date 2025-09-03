<?php
include 'auth.php';
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">
    <h2 class="mb-4 text-info">School Blog</h2>
    <div class="mb-4">
        <form method="POST" class="card card-body shadow-sm mb-3">
            <h5 class="mb-3">Post a New Article</h5>
            <input type="text" name="title" class="form-control mb-2" placeholder="Article Title" required>
            <textarea name="content" class="form-control mb-2" placeholder="Write your article..." rows="3" required></textarea>
            <button type="submit" name="post_blog" class="btn btn-info">Post Article</button>
        </form>
        <?php
        if (isset($_POST['post_blog'])) {
            $title = $conn->real_escape_string($_POST['title']);
            $content = $conn->real_escape_string($_POST['content']);
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO blog_posts (user_id, title, content) VALUES ($user_id, '$title', '$content')";
            if ($conn->query($sql)) {
                echo '<div class=\"alert alert-success\">Article posted!</div>';
            } else {
                echo '<div class=\"alert alert-danger\">Error posting article.</div>';
            }
        }
        ?>
    </div>
    <h4 class="mb-3">Recent Articles</h4>
    <?php
    $posts = $conn->query("SELECT p.*, u.username FROM blog_posts p LEFT JOIN users u ON p.user_id=u.id ORDER BY p.created_at DESC LIMIT 10");
    while ($post = $posts->fetch_assoc()):
    ?>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-info"><?php echo htmlspecialchars($post['title']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <div class="text-muted small">By <?php echo htmlspecialchars($post['username']); ?> on <?php echo date('d M Y H:i', strtotime($post['created_at'])); ?></div>
            <a href="view-blog.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-info btn-sm mt-2">View & Comment</a>
        </div>
    </div>
    <?php endwhile; ?>
</div>
</body>
</html>
