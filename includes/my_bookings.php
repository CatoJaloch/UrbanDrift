<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
  SELECT rb.id, ro.origin, ro.destination, ro.departure_date, ro.departure_time, rb.status
  FROM ride_bookings rb
  JOIN ride_offers ro ON rb.ride_id = ro.id
  WHERE rb.user_id = ?
  ORDER BY rb.requested_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Bookings</title>
  <link rel="stylesheet" href="../css/myride.css">
</head>
<body>
<div class="main-content">
  <h2>My Booking Requests</h2>
  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Route</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['origin'] ?> → <?= $row['destination'] ?></td>
          <td><?= $row['departure_date'] ?></td>
          <td><?= $row['departure_time'] ?></td>
          <td><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>You haven't booked any rides yet.</p>
  <?php endif; ?>
</div>
</body>
</html>
