<?php
session_start();
include '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$estate_id = intval($_SESSION['estate_id']);

// Handle deactivation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deactivate_id'])) {
  $userId = intval($_POST['deactivate_id']);
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $stmt->close();
}

// Fetch users from the same estate
$stmt = $conn->prepare("
  SELECT id, name, email, age, gender, is_verified 
  FROM users 
  WHERE estate_id = ?
");
$stmt->bind_param("i", $estate_id);
$stmt->execute();
$user_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>User Management - UrbanDrift</title>
  <link rel="stylesheet" href="../css/usermanagement.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .main-content { margin-left: 220px; padding: 20px; }
    .user-box {
      background: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
    }
    .user-box p { margin: 5px 0; }
    .submit-btn {
      padding: 8px 12px;
      background-color: #f44336;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    .submit-btn:disabled { background-color: #ccc; }
  </style>
</head>
<body>
  <?php include '../admin/admin_sidebar.php'; ?>
  <main class="main-content">
    <h2>Registered Users</h2>
    <?php if ($user_result && $user_result->num_rows > 0): ?>
      <?php while ($row = $user_result->fetch_assoc()): ?>
        <div class="user-box">
          <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
         <p><strong>Age / Gender:</strong> <?= htmlspecialchars($row['age'] ?? 'N/A') ?> / <?= htmlspecialchars($row['gender'] ?? 'N/A') ?></p>
          <p><strong>Verified:</strong> <?= $row['is_verified'] ? '✅ Yes' : '❌ No' ?></p>
          <form method="POST">
            <input type="hidden" name="deactivate_id" value="<?= $row['id'] ?>">
            <button class="submit-btn" type="submit">Deactivate</button>
          </form>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No users found for your estate.</p>
    <?php endif; ?>
  </main>
</body>
</html>
