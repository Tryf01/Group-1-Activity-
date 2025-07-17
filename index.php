<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="unified_styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode">
        <span id="darkModeIcon">🌙</span> </button>

    <div class="container index-container fade-in-container">
        <h1 class="page-title">Welcome to Student Management</h1>

        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'updated') {
                echo "<p class='success-message'>Student information updated successfully!</p>";
            } elseif ($_GET['status'] == 'added') {
                echo "<p class='success-message'>New student added successfully!</p>";
            } elseif ($_GET['status'] == 'deleted') {
                echo "<p class='success-message'>Student deleted successfully!</p>";
            }
        }
        ?>

        <div class="button-container">
            <a href="add_student.php" class="button primary">Add New Student</a>
            <a href="view_students.php" class="button secondary">View All Students</a>
            <a href="index.php?logout=true" class="button danger">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const iconSpan = document.getElementById('darkModeIcon');
            if (document.body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
                iconSpan.textContent = '☀️'; // Sun icon for light mode
            } else {
                localStorage.setItem('darkMode', 'disabled');
                iconSpan.textContent = '🌙'; // Moon icon for dark mode
            }
        }

        // Apply dark mode preference and set icon on page load
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