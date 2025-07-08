<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];
include '../includes/db.php';

// Ensure user is a driver
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

// Handle booking status update or removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['booking_id'])) {
  $booking_id = intval($_POST['booking_id']);
  
  if ($_POST['action'] === 'remove') {
    $update = $conn->prepare("UPDATE ride_bookings SET status = 'removed' WHERE id = ? AND ride_id IN (SELECT id FROM ride_offers WHERE user_id = ?)");
    $update->bind_param("ii", $booking_id, $user_id);
  } else {
    $action = $_POST['action'] === 'accepted' ? 'accepted' : 'rejected';
    $update = $conn->prepare("UPDATE ride_bookings SET status = ? WHERE id = ? AND ride_id IN (SELECT id FROM ride_offers WHERE user_id = ?)");
    $update->bind_param("sii", $action, $booking_id, $user_id);
  }
  $update->execute();
  $update->close();
}
 
// Retrieve booking requests for your rides
$stmt = $conn->prepare("
  SELECT rb.id AS booking_id,
         u.name AS passenger,
         ro.origin, 
         ro.destination, 
         ro.departure_date,
         ro.departure_time,
         rb.status
  FROM ride_bookings rb
  JOIN ride_offers ro ON rb.ride_id = ro.id
  JOIN users u ON rb.user_id = u.id
  WHERE ro.user_id = ?
  ORDER BY rb.requested_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Ride Requests</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    .main-content { 
  margin-left: 220px; 
  padding: 60px 20px 20px;  /* Added top padding to push content below navbar */
}

    table { width:100%; border-collapse:collapse; color:#333; }
  .thead{ background-color:purple;}
    th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
    th { background:#f0f0f0; }
    button { padding:6px 10px; margin-right:5px; border:none; border-radius:4px; cursor:pointer; }
    .accept-btn { background:#4caf50; color:white; }
    .reject-btn { background:#f44336; color:white; }
    .remove-btn { background:purple; color:white; }
  </style>
</head>
<body>
  <?php include '../includes/sidebar.php'; ?>
  <?php include '../includes/navbar.php'; ?>
  <main class="main-content">
    <h2>Passenger Requests for Your Rides</h2>
    <?php if ($result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Passenger</th>
            <th>Route</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($r = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['passenger']) ?></td>
            <td><?= htmlspecialchars($r['origin']) ?> → <?= htmlspecialchars($r['destination']) ?></td>
            <td><?= htmlspecialchars($r['departure_date']) ?></td>
            <td><?= ucfirst($r['status']) ?></td>
            <td>
              <?php if ($r['status'] === 'pending'): ?>
                <form method="post" style="display:inline">
                  <input type="hidden" name="booking_id" value="<?= $r['booking_id'] ?>">
                  <button name="action" value="accepted" class="accept-btn">✅ Accept</button>
                  <button name="action" value="rejected" class="reject-btn">❌ Reject</button>
                </form>
              <?php elseif ($r['status'] === 'accepted'): ?>
                <form method="post" style="display:inline">
                  <input type="hidden" name="booking_id" value="<?= $r['booking_id'] ?>">
                  <button name="action" value="remove" class="remove-btn">🗑️ Remove Passenger</button>
                </form>
              <?php else: ?>
                <?= ucfirst($r['status']) ?>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No passenger requests yet.</p>
    <?php endif; ?>
  </main>
</body>
</html>
