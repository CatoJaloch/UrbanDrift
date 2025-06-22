<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, gender, age, profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $gender, $age, $profile_image);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Profile</title>
  <link rel="stylesheet" href="../css/profile.css" />
</head>
<body>
<div class="main-content">
  <h2>User Profile</h2>
  <div class="profile-card">
    <div class="profile-img">
      <?php if ($profile_image): ?>
        <img src="../uploads/<?= htmlspecialchars($profile_image) ?>" alt="Profile Image">
      <?php else: ?>
        <img src="../uploads/default.png" alt="Default Profile Image">
      <?php endif; ?>
    </div>
    <div class="profile-info">
      <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
      <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
    </div>
    <form action="upload_image.php" method="post" enctype="multipart/form-data">
      <label>Update Profile Image:</label>
      <input type="file" name="profile_image" required>
      <button type="submit">Upload</button>
    </form>
  </div>
</div>
</body>
</html>
