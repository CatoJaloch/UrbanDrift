<?php
session_start();
include '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure estate_id exists
if (!isset($_SESSION['estate_id'])) {
  die("Access denied. Estate ID not found in session.");
}

$estate_id = intval($_SESSION['estate_id']);

// Handle verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['action'])) {
  $uid = intval($_POST['user_id']);
  if ($_POST['action'] === 'approve') {
    $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verified_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();
  } elseif ($_POST['action'] === 'decline') {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->close();
  }
}

// Fetch pending users for this estate only
$stmt = $conn->prepare("
  SELECT id, name, email, house_number, verification_requested_at
  FROM users
  WHERE is_verified = 0 AND estate_id = ?
");
$stmt->bind_param("i", $estate_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Verification - UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .main-content { margin-left: 220px; padding: 20px; }
    table { width: 100%; border-collapse: collapse; background: #fff; }
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #f0f0f0; }
    button { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
    button[value="approve"] { background: #4caf50; color: white; }
    button[value="decline"] { background: #f44336; color: white; }
  </style>
</head>
<body>
  <?php include '../admin/admin_sidebar.php'; ?>
  <main class="main-content">
    <h2>Pending Verifications</h2>
    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <thead>
          <tr><th>Name</th><th>Email</th><th>House #</th><th>Requested At</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['house_number']) ?></td>
              <td><?= $row['verification_requested_at'] ?></td>
              <td>
                <form method="POST">
                  <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                  <button name="action" value="approve">Approve</button>
                  <button name="action" value="decline">Decline</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No pending verification requests.</p>
    <?php endif; ?>
  </main>
</body>
</html>
