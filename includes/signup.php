<?php
session_start();
include '../includes/db.php'; // Your DB connection

// Enable error display for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$signup_success = false;
$signup_error = '';
$login_error = '';

// === SIGNUP HANDLER ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $gender = trim($_POST['gender']);
  $age = intval($_POST['age']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  if (empty($name) || empty($email) || empty($_POST['password'])) {
    $signup_error = "Please fill in all required fields.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $signup_error = "Email is already registered.";
    } else {
      $stmt_insert = $conn->prepare("
        INSERT INTO users (name, email, password, gender, age)
        VALUES (?, ?, ?, ?, ?)
      ");
      $stmt_insert->bind_param("ssssi", $name, $email, $password, $gender, $age);
      if ($stmt_insert->execute()) {
        $signup_success = true;
      } else {
        $signup_error = "Signup failed. Please try again.";
      }
      $stmt_insert->close();
    }
    $stmt->close();
  }
}

// === LOGIN HANDLER ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = trim($_POST['login_email']);
  $password = $_POST['login_password'];

  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      header("Location: dashboard.php");
      exit;
    } else {
      $login_error = "Incorrect password.";
    }
  } else {
    $login_error = "No account found with that email.";
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>UrbanDrift Signup / Login</title>
  <link rel="stylesheet" href="../css/signup.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div style="margin-left: 220px; padding: 40px;">
  <div class="container" id="container">

    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
      <form method="post" action="">
        <h1>Create Account</h1>
        <?php if ($signup_success): ?>
          <p style="color:green;">✅ Account created! Please sign in below.</p>
        <?php elseif ($signup_error): ?>
          <p style="color:red;"><?php echo $signup_error; ?></p>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="text" name="gender" placeholder="Gender (M/F)" />
        <input type="number" name="age" placeholder="Age" />
        <button type="submit" name="signup">Sign Up</button>
      </form>
    </div>

    <!-- Login Form -->
    <div class="form-container sign-in-container">
      <form method="post" action="">
        <h1>Sign In</h1>
        <?php if ($login_error): ?>
          <p style="color:red;"><?php echo $login_error; ?></p>
        <?php endif; ?>

        <input type="email" name="login_email" placeholder="Email" required />
        <input type="password" name="login_password" placeholder="Password" required />
        <button type="submit" name="login">Sign In</button>
      </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Already have an account?</h2>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>New here?</h2>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  const container = document.getElementById('container');
  document.getElementById('signUp').onclick = () => container.classList.add("right-panel-active");
  document.getElementById('signIn').onclick = () => container.classList.remove("right-panel-active");
</script>

</body>
</html>
