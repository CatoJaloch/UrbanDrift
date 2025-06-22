<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  die("You must be logged in to book a ride.");
}

$user_id = $_SESSION['user_id'];
$ride_id = $_POST['ride_id'] ?? null;

if ($ride_id) {
  $stmt = $conn->prepare("INSERT INTO ride_bookings (ride_id, user_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $ride_id, $user_id);

  if ($stmt->execute()) {
    echo "✅ Booking request sent!";
  } else {
    echo "❌ Could not send request: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "⚠️ Ride ID missing.";
}

$conn->close();
?>
