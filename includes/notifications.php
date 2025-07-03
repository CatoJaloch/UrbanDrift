<?php
session_start();
include '../includes/db.php';
include '../includes/navbar.php';
include '../includes/sidebar.php';

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch relevant notifications
$stmt = $conn->prepare("
  SELECT n.id, n.message, n.created_at, u.name AS related_name
  FROM notifications n
  LEFT JOIN users u ON n.related_user_id = u.id
  WHERE n.user_id = ?
  ORDER BY n.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notifications - UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    .main-content { margin-left: 220px; padding: 80px 20px; }
    .notification-box {
      background: #fff;
      border: 1px solid #ccc;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 10px;
    }
    .notification-box small { color: #666; }
  </style>
</head>
<body>
<main class="main-content">
  <h2>Your Notifications</h2>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="notification-box">
        <p><?= htmlspecialchars($row['message']) ?></p>
        <?php if ($row['related_name']): ?>
          <small>Related user: <?= htmlspecialchars($row['related_name']) ?></small><br>
        <?php endif; ?>
        <small><?= $row['created_at'] ?></small>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No notifications yet.</p>
  <?php endif; ?>
</main>
</body>
</html>
