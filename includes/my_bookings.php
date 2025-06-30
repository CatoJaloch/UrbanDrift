<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
  SELECT 
    rb.id AS booking_id,
    ro.id AS ride_id,
    ro.origin,
    ro.destination,
    ro.departure_date,
    ro.departure_time,
    ro.status,
    ro.rating_by_passenger,
    a.name AS driver_name
  FROM ride_bookings rb
  JOIN ride_offers ro ON rb.ride_id = ro.id
  JOIN users a ON ro.user_id = a.id
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
  <style>
    .main-content { margin-left: 220px; padding: 80px 20px 20px; }
    .btn-rate {
      background-color: #4caf50;
      color: white;
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      text-decoration: none;
    }
  </style>
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
          <th>Driver</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['origin']) ?> → <?= htmlspecialchars($row['destination']) ?></td>
          <td><?= $row['departure_date'] ?></td>
          <td><?= $row['departure_time'] ?></td>
          <td><?= htmlspecialchars($row['driver_name']) ?></td>
          <td><?= ucfirst($row['status']) ?></td>
          <td>
            <?php if ($row['status'] === 'completed' && !$row['rating_by_passenger']): ?>
              <a class="btn-rate" href="rate_driver.php?ride_id=<?= $row['ride_id'] ?>">Rate </a>
            <?php elseif ($row['rating_by_passenger']): ?>
              ✅ Rated
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
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
