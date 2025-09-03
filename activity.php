<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Usage: include 'activity.php'; log_activity($action, $student_id);
function log_activity($action, $student_id = null) {
    include 'db.php';
    $user_id = $_SESSION['user_id'] ?? null;
    if ($user_id) {
        $stmt = $conn->prepare("INSERT INTO activity_log (user_id, action, student_id) VALUES (?, ?, ?)");
        $stmt->bind_param('isi', $user_id, $action, $student_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
