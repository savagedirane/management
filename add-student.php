<?php include 'auth.php'; include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            background: url('add.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
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
        form {
            display: flex;
            flex-direction: column;
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: green;
        }
        .error {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Student</h2>
        <form action="add-student.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="text" name="course" placeholder="Course" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="dob" placeholder="Date of Birth" required>
            <input type="number" name="enrollment_year" placeholder="Enrollment Year" required>
            <input type="file" name="photo" accept="image/*" required>
            <button type="submit" name="submit">Add Student</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $first_name = $conn->real_escape_string($_POST['first_name']);
            $last_name = $conn->real_escape_string($_POST['last_name']);
            $age = (int)$_POST['age'];
            $course = $conn->real_escape_string($_POST['course']);
            $email = $conn->real_escape_string($_POST['email']);
            $dob = $_POST['dob'];
            $enrollment_year = (int)$_POST['enrollment_year'];

            // Handle photo upload
            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "uploads/";
                $photo_name = time() . '_' . basename($_FILES['photo']['name']);
                $target_file = $target_dir . $photo_name;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $valid_types = ['jpg','jpeg','png','gif'];
                if (in_array($imageFileType, $valid_types)) {
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                        $photo = $photo_name;
                    } else {
                        echo "<p class='error'>Photo upload failed.</p>";
                    }
                } else {
                    echo "<p class='error'>Invalid photo format.</p>";
                }
            }

            $sql = "INSERT INTO students (first_name, last_name, course, email, dob, enrollment_year, photo) 
                    VALUES ('$first_name', '$last_name', '$course', '$email', '$dob', $enrollment_year, '$photo')";

            if ($conn->query($sql) === TRUE) {
                // Send email notification (to admin)
                $to = 'fonchamdirane@gmail               .com'; // Change to your admin email
                $subject = 'New Student Added';
                $message = "A new student has been added:\n\n" .
                    "Name: $first_name $last_name\n" .
                    "Course: $course\n" .
                    "Email: $email\n" .
                    "Enrollment Year: $enrollment_year\n";
                @mail($to, $subject, $message);

                // Log activity
                include_once 'activity.php';
                log_activity('Added student', $conn->insert_id);

                echo "<p class='message'>Student added successfully!</p>";
            } else {
                echo "<p class='error'>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
