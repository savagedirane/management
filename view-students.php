<?php include 'auth.php'; include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: url('student.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for readability */
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #007bff;
        }
        table {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;}
        
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student List</h2>
    <form method="GET" class="mb-4 d-flex flex-wrap justify-content-center gap-2">
            <input type="text" name="search_name" class="form-control" style="max-width:180px;" placeholder="Name" value="<?= htmlspecialchars($_GET['search_name'] ?? '') ?>">
            <input type="text" name="search_course" class="form-control" style="max-width:180px;" placeholder="Course" value="<?= htmlspecialchars($_GET['search_course'] ?? '') ?>">
            <input type="number" name="search_year" class="form-control" style="max-width:180px;" placeholder="Enrollment Year" value="<?= htmlspecialchars($_GET['search_year'] ?? '') ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="view-students.php" class="btn btn-secondary">Reset</a>
            <a href="export-students.php?search_name=<?=urlencode($_GET['search_name']??'')?>&search_course=<?=urlencode($_GET['search_course']??'')?>&search_year=<?=urlencode($_GET['search_year']??'')?>" class="btn btn-success">Export to CSV</a>
        </form>
        <table border="1" cellpadding="15" cellspacing="15">
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Enrollment Year</th>
                <th>Course</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            // Build filter SQL
            $where = [];
            if (!empty($_GET['search_name'])) {
                $name = $conn->real_escape_string($_GET['search_name']);
                $where[] = "(first_name LIKE '%$name%' OR last_name LIKE '%$name%')";
            }
            if (!empty($_GET['search_course'])) {
                $course = $conn->real_escape_string($_GET['search_course']);
                $where[] = "course LIKE '%$course%'";
            }
            if (!empty($_GET['search_year'])) {
                $year = (int)$_GET['search_year'];
                $where[] = "enrollment_year = $year";
            }
            $sql = "SELECT * FROM students";
            if ($where) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $photo_html = $row['photo'] ? "<img src='uploads/{$row['photo']}' alt='Photo' style='width:50px;height:50px;border-radius:50%;object-fit:cover;'>" : "<span style='color:#aaa;'>No Photo</span>";
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$photo_html}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['dob']}</td>
                            <td>{$row['enrollment_year']}</td>
                            <td>{$row['course']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a href='update-student.php?id={$row['id']}'>Update</a> |
                                <a href='delete-student.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No students found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
