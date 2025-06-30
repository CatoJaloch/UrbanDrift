<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ride_id'])) {
  $ride_id = intval($_POST['ride_id']);
  $user_id = $_SESSION['user_id'];

  // Delete only if the ride belongs to the driver and is completed
  $stmt = $conn->prepare("DELETE FROM ride_offers WHERE id = ? AND user_id = ? AND status = 'completed'");
  $stmt->bind_param("ii", $ride_id, $user_id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['msg'] = "✅ Ride deleted successfully.";
  } else {
    $_SESSION['msg'] = "❌ Could not delete the ride. Make sure it's completed.";
  }

  $stmt->close();
}

header("Location: myrides.php");
exit;
