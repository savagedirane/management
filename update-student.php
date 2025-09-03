<?php include 'auth.php'; include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        body {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update Student</h2>
        <?php
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $result = $conn->query("SELECT * FROM students WHERE id = $id");
            $student = $result->fetch_assoc();
        }

        if (isset($_POST['update'])) {
            $id = (int)$_POST['id'];
            $first_name = $conn->real_escape_string($_POST['first_name']);
            $last_name = $conn->real_escape_string($_POST['last_name']);
            $dob = $_POST['dob'];
            $enrollment_year = (int)$_POST['enrollment_year'];
            $course = $conn->real_escape_string($_POST['course']);
            $email = $conn->real_escape_string($_POST['email']);

            $sql = "UPDATE students 
                    SET first_name = '$first_name', last_name = '$last_name', dob = '$dob', enrollment_year = $enrollment_year, course = '$course', email = '$email' 
                    WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                // Log activity
                include_once 'activity.php';
                log_activity('Updated student', $id);
                echo "<p>Student updated successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>

        <form action="update-student.php?id=<?= $student['id'] ?>" method="POST">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <input type="text" name="first_name" value="<?= $student['first_name'] ?? '' ?>" placeholder="First Name" required>
            <input type="text" name="last_name" value="<?= $student['last_name'] ?? '' ?>" placeholder="Last Name" required>
            <input type="date" name="dob" value="<?= $student['dob'] ?? '' ?>" placeholder="Date of Birth" required>
            <input type="number" name="enrollment_year" value="<?= $student['enrollment_year'] ?? '' ?>" placeholder="Enrollment Year" required>
            <input type="text" name="course" value="<?= $student['course'] ?? '' ?>" placeholder="Course" required>
            <input type="email" name="email" value="<?= $student['email'] ?? '' ?>" placeholder="Email" required>
            <button type="submit" name="update">Update Student</button>
        </form>
        
    </div>
</body>
</html>
