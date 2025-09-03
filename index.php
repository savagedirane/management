<?php
include 'auth.php';
include 'db.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vishi University </title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> 
    
<div class="position-absolute top-10 end-0 p-3 text-end" style="z-index:2;">
                    <div id="school-clock" style="font-size:1.3em; font-weight:bold; color:#333;"></div>
                    <div id="school-date" style="font-size:1em; color:#555;"></div>
                    <div style="font-size:1em; color:#007bff;">Location: bonaberi,nestle</div>
                </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-primary" href="home.php">Vishi University</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="create-user.php">Create Account</a></li>
    
        <li class="nav-item"><a class="nav-link" href="javascript:history.back()">Back</a></li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container py-5">
        <div class="row align-items-center bg-white rounded-4 shadow-lg p-4 mb-4 border border-primary">
            <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                <img src="view.jpg" alt="British university campus" class="img-fluid rounded-4 shadow border border-secondary">
            </div>
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-primary mb-2">Vishi University</h1>
                <h3 class="fw-light text-secondary mb-3">Welcome to Our Campus</h3>
                <p class="lead mb-4">Explore our modern university management system, designed for seamless student and staff administration, analytics, and collaboration.</p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="login.php" class="btn btn-primary btn-lg">Login</a>
                    <a href="create-user.php" class="btn btn-success btn-lg">Create Account</a>
                    <a href="forum.php" class="btn btn-success btn-lg">School Forum</a>
                    <a href="blog.php" class="btn btn-info btn-lg">School Blog</a>
                </div>
               
            </div>
        </div>
        <div class="bg-light rounded-4 shadow p-4 mb-4 border border-info">
            <h2 class="text-primary mb-3">About Vishi University</h2>
            <p class="fs-5">
                Vishi University is committed to academic excellence, innovation, and student success. Our digital platform empowers staff and students to manage records, view analytics, and collaborate efficiently.<br>
                <b>Get started by logging in or creating your account above!</b>
            </p>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100 shadow border border-success">
                    <div class="card-body">
                        <h4 class="card-title text-success">University Highlights</h4>
                        <ul>
                            <li>World-class faculty and research</li>
                            <li>Modern campus facilities</li>
                            <li>Student-centered learning</li>
                            <li>Active clubs and societies</li>
                            <li>Career development support</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow border border-primary">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Quick Links</h4>
                        <ul>
                            <li><a href="login.php">Login to Portal</a></li>
                            <li><a href="create-user.php">Create Account</a></li>
                            <li><a href="view-students.php">View Students</a></li>
                            <li><a href="add-student.php">Add Student</a></li>
                        </ul>
                        <h5 class="mt-4">Contact Us</h5>
                        <p>Email: info@vishiuniversity.edu<br>Phone:671354954</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        function updateClock() {
            const now = new Date();
            // Format time like a phone (HH:MM:SS AM/PM)
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0'+minutes : minutes;
            seconds = seconds < 10 ? '0'+seconds : seconds;
            const timeStr = `${hours}:${minutes}:${seconds} ${ampm}`;
            document.getElementById('school-clock').textContent = timeStr;
            // Format date (e.g., Monday, 28 August 2025)
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('school-date').textContent = now.toLocaleDateString('en-GB', options);
        }
        setInterval(updateClock, 1000);
        updateClock();
        </script>
</body>
</html>
