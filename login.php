<?php
//echo password_hash('yourpassword', PASSWORD_DEFAULT);
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: home.php');
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="min-height:100vh; background: url('add.jpg') no-repeat center center fixed; background-size: cover;">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height:100vh;">
        <div class="card p-4 shadow-lg w-100" style="max-width:400px; background: rgba(255,255,255,0.95);">
            <h2 class="mb-4 text-center text-primary">Login</h2>
            <?php if (!empty($error)) echo '<div class="alert alert-danger mb-3">'.$error.'</div>'; ?>
            <form method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
