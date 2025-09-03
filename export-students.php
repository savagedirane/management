<?php
include 'auth.php';
include 'db.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students.csv"');
$out = fopen('php://output', 'w');
fputcsv($out, ['ID', 'First Name', 'Last Name', 'Date of Birth', 'Enrollment Year', 'Course', 'Email']);
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
while ($row = $result->fetch_assoc()) {
    fputcsv($out, [
        $row['id'],
        $row['first_name'],
        $row['last_name'],
        $row['dob'],
        $row['enrollment_year'],
        $row['course'],
        $row['email']
    ]);
}
fclose($out);
exit;
?>
