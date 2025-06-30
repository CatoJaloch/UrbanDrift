<?php
session_start();
include '../includes/db.php';

$error = '';
$success = '';
$login_error = '';

// === SIGNUP ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $estate_name = trim($_POST['estate_name']);

  if (empty($name) || empty($email) || empty($_POST['password']) || empty($estate_name)) {
    $error = "Please fill in all fields.";
  } else {
    // Check if estate exists
    $check_stmt = $conn->prepare("SELECT id FROM estates WHERE name = ?");
    $check_stmt->bind_param("s", $estate_name);
    $check_stmt->execute();
    $check_stmt->bind_result($estate_id);
    $check_stmt->fetch();
    $check_stmt->close();

    // Insert new estate if it doesn't exist
    if (!$estate_id) {
      $insert_estate = $conn->prepare("INSERT INTO estates (name) VALUES (?)");
      $insert_estate->bind_param("s", $estate_name);
      $insert_estate->execute();
      $estate_id = $insert_estate->insert_id;
      $insert_estate->close();
    }

    // Register admin
    $signup_stmt = $conn->prepare("INSERT INTO admins (name, email, password, estate_id) VALUES (?, ?, ?, ?)");
    $signup_stmt->bind_param("sssi", $name, $email, $password, $estate_id);
    if ($signup_stmt->execute()) {
      $success = "✅ Admin account created successfully.";
    } else {
      $error = "Signup failed.";
    }
    $signup_stmt->close();
  }
}

// === LOGIN ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = trim($_POST['login_email']);
  $password = $_POST['login_password'];

  $login_stmt = $conn->prepare("SELECT id, name, estate_id, password FROM admins WHERE email = ?");
  $login_stmt->bind_param("s", $email);
  $login_stmt->execute();
  $result = $login_stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_id'] = $admin['id'];
      $_SESSION['admin_name'] = $admin['name'];
      $_SESSION['estate_id'] = $admin['estate_id'];
      header("Location: admin_dashboard.php");
      exit;
    } else {
      $login_error = "Incorrect password.";
    }
  } else {
    $login_error = "No admin found with that email.";
  }
  $login_stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Signup / Login - UrbanDrift</title>
  <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
<div class="container" id="container">
  <!-- Admin Signup -->
  <div class="form-container sign-up-container">
    <form method="POST">
      <h1>Admin Signup</h1>
      <?php if ($success): ?><p style="color:green;"><?= $success ?></p><?php endif; ?>
      <?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="text" name="estate_name" placeholder="Estate Name" required />
      <button type="submit" name="signup">Sign Up</button>
    </form>
  </div>

  <!-- Admin Login -->
  <div class="form-container sign-in-container">
    <form method="POST">
      <h1>Admin Login</h1>
      <?php if ($login_error): ?><p style="color:red;"><?= $login_error ?></p><?php endif; ?>
      <input type="email" name="login_email" placeholder="Email" required />
      <input type="password" name="login_password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
    </form>
  </div>

  <!-- Toggle Overlay -->
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h2>Already Admin?</h2>
        <button class="ghost" id="signIn">Login</button>
      </div>
      <div class="overlay-panel overlay-right">
        <h2>New Admin?</h2>
        <a href ="../includes/signup.php" class="admin-link"> user signup</a>
        <button class="ghost" id="signUp">Sign Up</button>
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
