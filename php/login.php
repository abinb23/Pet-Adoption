<?php
include('dbconnect.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if email exists in the database
  $stmt = $conn->prepare("SELECT * FROM signup WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) {
      session_start();
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      header("Location: dashboard.php");
      exit();
    } else {
      $message = "Invalid email or password!";
    }
  } else {
    $message = "No account found with that email!";
  }

  $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="/css/login.css" />
  <title>Pawsome - Login</title>
  <link rel="icon" href="/images/fav.png" type="image/x-icon" />
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-in">
      <form action="login.php" method="POST">
        <h1>Login</h1>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <a href="#">Forget Your Password?</a>
        <button type="submit">Login</button>
        <?php if ($message): ?>
          <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
      </form>
    </div>

    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Welcome Back!</h1>
          <p>Enter your personal details to use all site features</p>
          <button class="hidden" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Hello, Friend!</h1>
          <p>
            Register with your personal details to use all site features
          </p>
          <button class="hidden" id="register">Sign Up</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const container = document.getElementById("container");
    const registerBtn = document.getElementById("register");
    const loginBtn = document.getElementById("login");

    // Default to the sign-in form
    window.onload = () => {
      container.classList.remove("active");
    };

    registerBtn.addEventListener("click", () => {
      container.classList.add("active");
    });

    loginBtn.addEventListener("click", () => {
      container.classList.remove("active");
    });
  </script>
</body>

</html>