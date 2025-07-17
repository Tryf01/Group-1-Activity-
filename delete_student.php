<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p style='color:red; text-align:center;'>No student ID provided.</p>";
    exit();
}

$student_id = intval($_GET['id']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);

if ($stmt->execute()) {
    header("Location: view_students.php?status=deleted");
    exit();
} else {
    echo "<p style='color:red; text-align:center;'>Error deleting student. Please try again.</p>";
}

$stmt->close();
$conn->close();
?>