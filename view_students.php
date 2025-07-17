<?php
// PHP database connection and query logic
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<p class='error-message'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
}

// Initialize search query
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    // Modified SQL query to search by name, email, OR course
    $sql = "SELECT id, name, email, course, dob FROM students WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%' OR course LIKE '%$search_query%'";
} else {
    $sql = "SELECT id, name, email, course, dob FROM students";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="unified_styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <button class="dark-mode-toggle" onclick="toggleDarkMode()" aria-label="Toggle Dark Mode">
        <span id="darkModeIcon">🌙</span> </button>

    <div class="container fade-in-container">
        <h2>Student List</h2>

        <div class="search-form-centered">
            <form class="search-form" action="view_students.php" method="get">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="search_input" class="sr-only">Search Students</label>
                    <input type="text" id="search_input" name="search" placeholder="Search by name, email, or course" value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <button type="submit" class="button primary small-button">Search</button>
            </form>
        </div>


        <?php
        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Date of Birth</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["course"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["dob"]) . "</td>";
                echo "<td class='action-links'>";
                echo "<a href='edit_student.php?id=" . urlencode($row["id"]) . "' class='edit-link'>Edit</a>";
                echo "<a href='delete_student.php?id=" . urlencode($row["id"]) . "' class='delete-link' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No students found matching your criteria. Add some students or adjust your search!</p>";
        }

        $conn->close();
        ?>
        <div class="back-button-container ">
            <a href="index.php" class="back-button">HOME</a>
        </div>
    </div>

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