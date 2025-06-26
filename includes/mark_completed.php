<?php
session_start();
include '../includes/db.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ride_id'])) {
  $ride_id = intval($_POST['ride_id']);

  // Verify ride ownership
  $stmt = $conn->prepare("SELECT id FROM ride_offers WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $ride_id, $user_id);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->close();

    // Update status
    $update = $conn->prepare("UPDATE ride_offers SET status = 'completed' WHERE id = ?");
    $update->bind_param("i", $ride_id);
    $update->execute();
    $update->close();
  } else {
    $stmt->close();
    // Optional: handle unauthorized attempt
  }
}

$conn->close();
header("Location: myrides.php");
exit;
?>
