<?php
include 'db.php';
if (isset($_POST['create'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>User created successfully!</p>";
    } else {
        echo "<p style='color:red'>Error: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="min-height:100vh; background: url('add.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card p-4 shadow-lg w-100" style="max-width:400px; background: rgba(255,255,255,0.95);">
            <h2 class="mb-4 text-center text-success">Create User</h2>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <button type="submit" name="create" class="btn btn-success w-100">Create User</button>
            </form>
        </div>
    </div>
</body>
</html>
