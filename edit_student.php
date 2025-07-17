<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<p class='error-message'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p class='error-message'>No student ID provided.</p>";
    exit();
}

$student_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['student_name'];
    $email = $_POST['student_email'];
    $course = $_POST['student_course'];
    $dob = $_POST['student_dob'];

    if (empty($name) || empty($email) || empty($course) || empty($dob)) {
        echo "<p class='error-message'>All fields are required.</p>";
    } else {
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, course=?, dob=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $course, $dob, $student_id);
        if ($stmt->execute()) {
            header("Location: view_students.php?status=updated");
            exit();
        } else {
            echo "<p class='error-message'>Error updating student: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    }
} else {
    // Fetch student data for editing
    $stmt = $conn->prepare("SELECT name, email, course, dob FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $name = $student['name'];
        $email = $student['email'];
        $course = $student['course'];
        $dob = $student['dob'];
    } else {
        echo "<p class='error-message'>Student not found.</p>";
        exit();
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="unified_styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode">
        <span id="darkModeIcon">🌙</span> </button>

    <div class="container form-container fade-in-container">
        <h2>Edit Student</h2>
        <form action="edit_student.php?id=<?php echo urlencode($student_id); ?>" method="post">
            <div class="form-group">
                <label for="student_name">Name:</label>
                <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <div class="form-group">
                <label for="student_email">Email:</label>
                <input type="email" id="student_email" name="student_email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="form-group">
                <label for="student_course">Course:</label>
                <select id="student_course" name="student_course" required>
                    <option value="" disabled>Select course</option>
                    <?php
                    $courses = ["Accountancy", "Artificial Intelligence", "Bachelor of Science in Information Technology", "Blockchain Technology", "Business Administration", "Computer Engineering", "Computer Science", "Cybersecurity", "Data Science", "Electronics Engineering", "Hospitality Management", "Industrial Engineering", "Information Systems"];
                    foreach ($courses as $c) {
                        echo "<option value=\"" . htmlspecialchars($c) . "\"" . ($course == $c ? " selected" : "") . ">" . htmlspecialchars($c) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="student_dob">Date of Birth:</label>
                <input type="date" id="student_dob" name="student_dob" value="<?php echo htmlspecialchars($dob); ?>" required>
            </div>

            <input type="submit" value="Update Student" class="button primary form-submit-button">
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