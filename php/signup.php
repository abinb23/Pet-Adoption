<?php

include('dbconnect.php');
// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  // Check if passwords match
  if ($password === $confirmPassword) {
    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data into the database
    $sql = "INSERT INTO signup (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
      // Redirect to the login page if signup is successful
      header("Location: login.php");
      exit();
    } else {
      $message = "SQL Error: " . mysqli_error($conn);
    }
  } else {
    $message = "Passwords do not match!";
  }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="/css/signup.css" />
  <title>Pawsome - Signup</title>
  <link rel="icon" href="/images/fav.png" type="image/x-icon" />
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up">
      <form action="signup.php" method="POST">
        <h1>Create Account</h1>
        <input type="text" name="username" placeholder="Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="confirm-password" placeholder="Confirm Password" required />
        <button type="submit">Sign Up</button>
        <?php if ($message): ?>
          <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
      </form>
    </div>
  </div>
</body>

</html>