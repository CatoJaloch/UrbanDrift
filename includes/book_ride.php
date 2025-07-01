<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  die("⚠️ You must be logged in to book a ride.");
}

$user_id = $_SESSION['user_id'];
$ride_id = intval($_POST['ride_id'] ?? 0);
$seats_requested = intval($_POST['seats'] ?? 0);

if ($ride_id <= 0 || $seats_requested <= 0) {
  die("⚠️ Ride ID or seats missing or invalid.");
}

// Check available seats
$stmt = $conn->prepare("
  SELECT r.seats, 
    COALESCE((
      SELECT SUM(b.seats_requested) 
      FROM ride_bookings b 
      WHERE b.ride_id = r.id AND b.status = 'accepted'
    ), 0) AS booked
  FROM ride_offers r
  WHERE r.id = ?
");
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$stmt->bind_result($total_seats, $booked);
$stmt->fetch();
$stmt->close();

$available = $total_seats - $booked;

if ($seats_requested > $available) {
  die("❌ Not enough seats available. Requested: $seats_requested, Available: $available");
}

// Insert booking
$stmt = $conn->prepare("
  INSERT INTO ride_bookings (ride_id, user_id, seats_requested, status, requested_at)
  VALUES (?, ?, ?, 'pending', NOW())
");
$stmt->bind_param("iii", $ride_id, $user_id, $seats_requested);

if ($stmt->execute()) {
  echo "✅ Booking request for $seats_requested seat" . ($seats_requested > 1 ? "s" : "") . " sent!";
} else {
  echo "❌ Could not send request: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
