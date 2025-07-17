<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['student_name'];
    $email = $_POST['student_email'];
    $course = $_POST['student_course'];
    $dob = $_POST['student_dob'];


    if (empty($name) || empty($email) || empty($course) || empty($dob)) {
        echo "<p class='error-message'>Error: All fields are required.</p>";
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<p class='error-message'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
    }

    $stmt = $conn->prepare("INSERT INTO students (name, email, course, dob) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssss", $name, $email, $course, $dob);

    if ($stmt->execute()) {

        header("Location: view_students.php?status=added");
        exit();
    } else {

        error_log("Error adding student: " . $stmt->error);
        echo "<p class='error-message'>Error adding student. Please try again.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add New Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="unified_styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode">
        <span id="darkModeIcon">🌙</span> </button>

    <div class="container form-container fade-in-container">
        <h2>Add New Student</h2>
        <form action="add_student.php" method="post">
            <div class="form-group">
                <label for="student_name">Name:</label>
                <input type="text" id="student_name" name="student_name" required>
            </div>

            <div class="form-group">
                <label for="student_email">Email:</label>
                <input type="email" id="student_email" name="student_email" required>
            </div>

            <div class="form-group">
                <label for="student_course">Course:</label>
                <select id="student_course" name="student_course" required>
                    <option value="" disabled selected>Select course</option>
                    <option>Accountancy</option>
                    <option>Artificial Intelligence</option>
                    <option>Bachelor of Science in Information Technology</option>
                    <option>Blockchain Technology</option>
                    <option>Business Administration</option>
                    <option>Computer Engineering</option>
                    <option>Computer Science</option>
                    <option>Cybersecurity</option>
                    <option>Data Science</option>
                    <option>Electronics Engineering</option>
                    <option>Hospitality Management</option>
                    <option>Industrial Engineering</option>
                    <option>Information Systems</option>
                </select>
            </div>

            <div class="form-group">
                <label for="student_dob">Date of Birth:</label>
                <input type="date" id="student_dob" name="student_dob" required>
            </div>

            <input type="submit" value="Add Student" class="button primary form-submit-button">
        </form>
        <a href="index.php" class="back-button">HOME</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const iconSpan = document.getElementById('darkModeIcon');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                iconSpan.textContent = '☀️';
            } else {
                localStorage.setItem('darkMode', 'disabled');
                iconSpan.textContent = '🌙';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const iconSpan = document.getElementById('darkModeIcon');
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.body.classList.add('dark-mode');
                iconSpan.textContent = '☀️';
            } else {
                iconSpan.textContent = '🌙';
            }
        });
    </script>
</body>
</html>