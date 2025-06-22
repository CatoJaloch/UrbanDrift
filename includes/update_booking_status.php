<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $booking_id = $_POST['booking_id'];
  $action = $_POST['action']; // "accepted" or "rejected"

  if (in_array($action, ['accepted', 'rejected'])) {
    $stmt = $conn->prepare("UPDATE ride_bookings SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $booking_id);
    $stmt->execute();
    $stmt->close();
  }
}

header("Location: manage_requests.php");
exit;
