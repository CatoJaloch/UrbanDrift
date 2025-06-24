<?php include 'db.php';
$user_id = intval($_POST['user_id']);
$action = $_POST['action'];

if ($action === 'approve') {
  $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verified_at = NOW() WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
} else {
  $conn->query("DELETE FROM users WHERE id = $user_id"); // or mark rejected
}

header("Location: manage_verification.php");
exit;
?>