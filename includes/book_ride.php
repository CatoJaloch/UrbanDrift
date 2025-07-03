<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  die("You must be logged in to book a ride.");
}

$user_id = $_SESSION['user_id'];
$ride_id = intval($_POST['ride_id'] ?? 0);
$seats_requested = intval($_POST['seats'] ?? 1);

// Validate input
if ($ride_id <= 0 || $seats_requested <= 0) {
  echo "⚠️ Ride ID or seats missing or invalid.";
  exit;
}

// Insert booking
$stmt = $conn->prepare("
  INSERT INTO ride_bookings (ride_id, user_id, seats_requested, status, requested_at)
  VALUES (?, ?, ?, 'pending', NOW())
");
$stmt->bind_param("iii", $ride_id, $user_id, $seats_requested);

if ($stmt->execute()) {
  echo "✅ Booking request sent!";

  // Fetch driver ID
  $driver_stmt = $conn->prepare("SELECT user_id, origin, destination FROM ride_offers WHERE id = ?");
  $driver_stmt->bind_param("i", $ride_id);
  $driver_stmt->execute();
  $driver_stmt->bind_result($driver_id, $origin, $destination);
  $driver_stmt->fetch();
  $driver_stmt->close();

  // Insert notification for driver
  $msg = "🚗 A passenger has requested $seats_requested seat(s) on your ride from $origin to $destination.";
  $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, related_user_id, message, created_at) VALUES (?, ?, ?, NOW())");
  $notif_stmt->bind_param("iis", $driver_id, $user_id, $msg);
  $notif_stmt->execute();
  $notif_stmt->close();

} else {
  echo "❌ Could not send request: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
