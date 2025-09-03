<?php include 'auth.php'; include 'db.php'; ?>

<?php
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM students WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Log activity
        include_once 'activity.php';
        log_activity('Deleted student', $id);
        echo "<p>Student deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
header("Location: view-students.php"); // Redirect back to the view-students page
exit;
?>