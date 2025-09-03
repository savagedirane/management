<?php
include 'auth.php';
include 'db.php';

// Dashboard data
$total_students = $conn->query("SELECT COUNT(*) as cnt FROM students")->fetch_assoc()['cnt'];
$course_stats = $conn->query("SELECT course, COUNT(*) as cnt FROM students GROUP BY course");
$recent_enrollments = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetch_assoc()['cnt'];
$staff_count = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE role='staff'")->fetch_assoc()['cnt'];
$male = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Male'")->fetch_assoc()['cnt'];
$female = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Female'")->fetch_assoc()['cnt'];
$other = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Other'")->fetch_assoc()['cnt'];
$activity = $conn->query("SELECT a.*, u.username FROM activity_log a LEFT JOIN users u ON a.user_id=u.id ORDER BY a.timestamp DESC LIMIT 5");
?>
