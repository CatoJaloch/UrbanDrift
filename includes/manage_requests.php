<?php

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];

include '../includes/db.php';

// Check if user is a driver
$stmt = $conn->prepare("SELECT is_driver FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_driver);
$stmt->fetch();
$stmt->close();

if (!$is_driver) {
  $_SESSION['message'] = "⚠️ Only registered drivers can access this page.";
  header("Location: become_driver.php");
  exit;
}

include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
  SELECT rb.id AS booking_id, rb.status, u.name, ro.origin, ro.destination, ro.departure_date, ro.departure_time
  FROM ride_bookings rb
  JOIN ride_offers ro ON rb.ride_id = ro.id
  JOIN users u ON rb.user_id = u.id
  WHERE ro.user_id = ?
  ORDER BY rb.requested_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Ride Requests</title>
  <link rel="stylesheet" href="../css/myride.css">
</head>
<body>
<div class="main-content">
  <h2>Passenger Requests for Your Rides</h2>
  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Passenger</th>
          <th>Route</th>
          <th>Date</th>
          <th>Time</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['name'] ?></td>
          <td><?= $row['origin'] ?> → <?= $row['destination'] ?></td>
          <td><?= $row['departure_date'] ?></td>
          <td><?= $row['departure_time'] ?></td>
          <td><?= ucfirst($row['status']) ?></td>
          <td>
            <?php if ($row['status'] == 'pending'): ?>
              <form action="update_booking_status.php" method="post" style="display:inline;">
                <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                <button name="action" value="accepted">✅ Accept</button>
                <button name="action" value="rejected">❌ Reject</button>
              </form>
            <?php else: ?>
              <?= ucfirst($row['status']) ?>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No one has booked your rides yet.</p>
  <?php endif; ?>
</div>
</body>
</html>
