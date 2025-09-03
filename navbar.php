<!-- Navbar for all pages -->
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
        <li class="nav-item"><a class="nav-link" href="view-students.php">View Students</a></li>
        <li class="nav-item"><a class="nav-link" href="add-student.php">Add Student</a></li>
        <li class="nav-item"><a class="nav-link" href="home.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="javascript:history.back()">Back</a></li>
      </ul>
      <div class="d-flex align-items-center ms-3">
        <div class="text-end me-3">
          <span id="school-clock" style="font-size:1.1em; font-weight:bold; color:#333;"></span><br>
          <span id="school-date" style="font-size:0.95em; color:#555;"></span><br>
          <span style="font-size:0.95em; color:#007bff;">London, UK</span>
        </div>
      </div>
    </div>
    <script>
    function updateClock() {
        const now = new Date();
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
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('school-date').textContent = now.toLocaleDateString('en-GB', options);
    }
    setInterval(updateClock, 1000);
    updateClock();
    </script>
  </div>
</nav>
 