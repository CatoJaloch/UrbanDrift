<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$booking_id = intval($_GET['booking_id'] ?? 0);

if (!$booking_id) {
  die("Invalid booking ID.");
}

// Fetch booking and passenger details
$stmt = $conn->prepare("
  SELECT rb.id AS booking_id, rb.status, rb.seats_requested, rb.requested_at,
         u.name AS passenger_name, u.email, u.gender, u.age, u.house_number,
         ro.origin, ro.destination, ro.departure_date, ro.departure_time
  FROM ride_bookings rb
  JOIN users u ON rb.user_id = u.id
  JOIN ride_offers ro ON rb.ride_id = ro.id
  WHERE rb.id = ? AND ro.user_id = ?
");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  die("Booking not found or access denied.");
}

$booking = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Passenger Details - UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    
    .main-content { margin-left: 220px; padding: 80px 20px; background image:url("../images/pexels-bertellifotografia-799443.jpg"); }
    .detail-box {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      max-width: 600px;
    }
    .detail-box p { margin: 8px 0; }
  </style>
</head>
<body>
  <main class="main-content">
    <h2>Passenger Booking Details</h2>

    <div class="detail-box">
      <p><strong>Passenger Name:</strong> <?= htmlspecialchars($booking['passenger_name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
      <p><strong>Gender:</strong> <?= htmlspecialchars($booking['gender']) ?></p>
      <p><strong>Age:</strong> <?= htmlspecialchars($booking['age']) ?></p>
      <p><strong>House :</strong> <?= htmlspecialchars($booking['house_number']) ?></p>

      <hr>

      <p><strong>Route:</strong> <?= htmlspecialchars($booking['origin']) ?> → <?= htmlspecialchars($booking['destination']) ?></p>
      <p><strong>Date:</strong> <?= $booking['departure_date'] ?></p>
      <p><strong>Time:</strong> <?= $booking['departure_time'] ?></p>
      <p><strong>Seats Requested:</strong> <?= $booking['seats_requested'] ?></p>
      <p><strong>Status:</strong> <?= ucfirst($booking['status']) ?></p>
      <p><strong>Requested At:</strong> <?= $booking['requested_at'] ?></p>
    </div>
  </main>
</body>
</html>
