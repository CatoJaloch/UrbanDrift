<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['action'])) {
  $booking_id = intval($_POST['booking_id']);
  $action = $_POST['action'];

  if (!in_array($action, ['accepted', 'rejected'])) {
    die("Invalid action.");
  }

  // Update booking status
  $stmt = $conn->prepare("UPDATE ride_bookings SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $action, $booking_id);
  if ($stmt->execute()) {
    // Get passenger ID + ride info
    $info_stmt = $conn->prepare("
      SELECT rb.user_id, ro.origin, ro.destination
      FROM ride_bookings rb
      JOIN ride_offers ro ON rb.ride_id = ro.id
      WHERE rb.id = ?
    ");
    $info_stmt->bind_param("i", $booking_id);
    $info_stmt->execute();
    $info_stmt->bind_result($passenger_id, $origin, $destination);
    $info_stmt->fetch();
    $info_stmt->close();

    // Insert notification for passenger
    $msg = $action === 'accepted' 
      ? "✅ Your booking for the ride from $origin to $destination was accepted!"
      : "❌ Your booking for the ride from $origin to $destination was rejected.";

    $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, related_user_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $notif_stmt->bind_param("iis", $passenger_id, $_SESSION['user_id'], $msg);
    $notif_stmt->execute();
    $notif_stmt->close();

    $_SESSION['msg'] = "Status updated and passenger notified.";
  } else {
    $_SESSION['msg'] = "Failed to update booking.";
  }

  $stmt->close();
}

header("Location: manage_requests.php");
exit;
?>
