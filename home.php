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
<!DOCTYPE html>
<html lang="en">
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vishi University Management</title>
<link rel="stylesheet" href="styles.css">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 </head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container py-5">
        <div class="row align-items-center bg-white rounded-4 shadow-lg p-4 mb-4 border border-primary">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                <img src="view.jpg" alt="British university campus" class="img-fluid rounded-4 shadow border border-secondary">
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-primary mb-2">vishi University </h1>
                <h3 class="fw-light text-secondary mb-3">Vishi University Management System</h3>
                <p class="lead mb-4">Welcome to the official dashboard. Here you can view key statistics, manage students, and monitor campus activity in a modern, professional style.</p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="add-student.php" class="btn btn-success btn-lg">Add Student</a>
                    <a href="view-students.php" class="btn btn-primary btn-lg">View Students</a>
                    <a href="update-student.php" class="btn btn-warning btn-lg">Update Student</a>
                    <a href="delete-student.php" class="btn btn-danger btn-lg">Delete Student</a>
                </div>
            </div>
        </div>
        <div class="bg-light rounded-4 shadow p-4 mb-4 border border-info">
            <h2 class="text-primary mb-3">University Overview</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card text-center border border-success">
                        <div class="card-body">
                            <h6 class="card-title text-secondary">Total Students</h6>
                            <p class="display-6 fw-bold text-success mb-0"><?php echo $total_students; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border border-warning">
                        <div class="card-body">
                            <h6 class="card-title text-secondary">Recent Enrollments (30 days)</h6>
                            <p class="display-6 fw-bold text-warning mb-0"><?php echo $recent_enrollments; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border border-info">
                        <div class="card-body">
                            <h6 class="card-title text-secondary">Staff Members</h6>
                            <p class="display-6 fw-bold text-info mb-0">
                                <?php 
                                $staff_count = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE role='staff'")->fetch_assoc()['cnt'];
                                echo $staff_count;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border border-primary">
                        <div class="card-body">
                            <h6 class="card-title text-secondary">Gender Ratio</h6>
                            <p class="mb-0">
                                <?php 
                                $male = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Male'")->fetch_assoc()['cnt'];
                                $female = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Female'")->fetch_assoc()['cnt'];
                                $other = $conn->query("SELECT COUNT(*) as cnt FROM students WHERE gender='Other'")->fetch_assoc()['cnt'];
                                echo "<span class='fw-bold text-primary'>M:</span> $male ";
                                echo "<span class='fw-bold text-danger'>F:</span> $female ";
                                echo "<span class='fw-bold text-secondary'>O:</span> $other";
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow border border-secondary">
                    <div class="card-body">
                        <h5 class="card-title text-center">Students Per Course</h5>
                        <ul class="list-group">
                        <?php while($row = $course_stats->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($row['course']); ?>
                                <span class="badge bg-success rounded-pill"><?php echo $row['cnt']; ?></span>
                            </li>
                        <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow border border-secondary">
                    <div class="card-body">
                        <h5 class="card-title text-center">Recent Activity</h5>
                        <ul class="list-group">
                        <?php 
                        $activity = $conn->query("SELECT a.*, u.username FROM activity_log a LEFT JOIN users u ON a.user_id=u.id ORDER BY a.timestamp DESC LIMIT 5");
                        while($act = $activity->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <span class="fw-bold text-primary"><?php echo htmlspecialchars($act['username']); ?></span> - <?php echo htmlspecialchars($act['action']); ?>
                                <span class="float-end text-muted" style="font-size:0.9em;"><?php echo date('d M Y H:i', strtotime($act['timestamp'])); ?></span>
                            </li>
                        <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>