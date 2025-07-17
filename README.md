# Group-1-Activity-
Here's a README.md file for your GitHub repository:

# Student Management System 

This repository contains a simple Student Management System developed using PHP and MySQL. It allows for basic CRUD (Create, Read, Update, Delete) operations on student records, along with a login system and dark mode functionality.

-----

## Group Members & Roles 

  * **Ocrisma, Daryl**: Developed the core program functionalities (PHP logic for adding, viewing, editing, and deleting students).
  * **Guarino, Chris Andrew**: Designed and implemented the CSS for the program's user interface.
  * **Dela Cruz, Marcovy**: Performed program touch-ups and refinements.

-----

## Project Overview 

The Student Management System is a web-based application designed to streamline the management of student information. Key features include:

  * **User Authentication**: A secure login page to control access to the system.
  * **Add Student**: Functionality to add new student records, including name, email, course, and date of birth.
  * **View Students**: A comprehensive list of all registered students with search capabilities.
  * **Edit Student**: Ability to modify existing student details.
  * **Delete Student**: Option to remove student records from the system.
  * **Responsive Design**: The application is designed to be accessible across various devices.
  * **Dark Mode Toggle**: Users can switch between light and dark themes for improved readability and user experience.

-----

## Setup Instructions 

To get this project up and running on your local machine, follow these steps:

### Prerequisites

Ensure you have the following installed:

  * **Web Server**: Apache or Nginx (e.g., part of XAMPP, WAMP, or MAMP)
  * **PHP**: Version 7.4 or higher
  * **MySQL Database**: Version 5.7 or higher

### Database Setup

1.  **Create Database**: Open your MySQL client (e.g., phpMyAdmin) and create a new database named `student_db`.

    ```sql
    CREATE DATABASE student_db;
    ```

2.  **Create Table**: Within the `student_db` database, execute the following SQL query to create the `students` table:

    ```sql
    CREATE TABLE students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        course VARCHAR(100),
        dob DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

3.  **User for Login**: The `login.php` file currently has hardcoded credentials:

      * Username: `student`
      * Password: `password`
        You can modify these directly in `login.php` if needed.

### Application Setup

1.  **Clone the Repository**:

    ```bash
    git clone <repository_url>
    cd <repository_name>
    ```

2.  **Place Files on Web Server**: Copy all the project files (including `add_student.php`, `view_students.php`, `login.php`, `unified_styles.css`, etc.) into your web server's document root (e.g., `htdocs` for XAMPP).

3.  **Configure Database Connection**: The database connection details are set in `add_student.php`, `delete_student.php`, `edit_student.php`, `login.php`, and `view_students.php`. Ensure these lines match your MySQL setup:

    ```php
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = "";     // Your MySQL password
    $dbname = "student_db";
    ```

    If your MySQL server has a password, update the `$password` variable accordingly.

### Running the Application

1.  **Start Web Server**: Ensure your Apache and MySQL services are running.

2.  **Access in Browser**: Open your web browser and navigate to the project's URL. For example, if you placed the files in `htdocs/student_management_system`, you would go to:
    `http://localhost/student_management_system/login.php`

    You will be redirected to the login page. Use the credentials mentioned in "Database Setup" to log in.
