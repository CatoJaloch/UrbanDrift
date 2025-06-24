<?php
session_start();
include '../includes/db.php';

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, name, password, estate_id FROM admins WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

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
    $login_error = "Admin not found.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Login - UrbanDrift</title>
  <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
  <div class="container" style="max-width: 400px; margin: 100px auto;">
    <h2>Admin Login</h2>
    <?php if ($login_error): ?>
      <p style="color: red;"><?= $login_error ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Admin Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="admin_signup.php">Sign Up</a></p>
  </div>
</body>
</html>
