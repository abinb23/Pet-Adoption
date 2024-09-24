<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pets"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required!";
    } else {
        // Sanitize and hash password
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into database
        $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Account created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
