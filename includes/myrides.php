<?php
session_start();
include '../includes/db.php';
include '../includes/navbar.php';
include '../includes/sidebar.php';

// Fetch user rides
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
  SELECT * FROM ride_offers
  WHERE user_id = ?
  ORDER BY departure_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Rides – UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    .main-content { margin-left: 220px; padding: 80px 20px 20px; }
    .ride-box { background:#fff;border:1px solid #ccc;border-radius:8px;padding:15px;margin-bottom:15px; }
    .btn-rate { margin-top:10px; background:#4caf50;color:#fff;padding:8px 12px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;}
  </style>
</head>
<body>
<main class="main-content">
  <h2>My Rides</h2>

  <?php while ($ride = $result->fetch_assoc()): ?>
    <div class="ride-box">
      <p><strong>Date:</strong> <?= htmlspecialchars($ride['departure_date']) ?></p>
      <p><strong>Route:</strong> <?= htmlspecialchars($ride['origin']) ?> → <?= htmlspecialchars($ride['destination']) ?></p>
      <p><strong>Seats:</strong> <?= $ride['seats'] ?></p>
      <p><strong>Comments:</strong> <?= htmlspecialchars($ride['comments']) ?></p>
      <p><strong>Status:</strong> <?= ucfirst($ride['status']) ?></p>
<!-- Show Mark as Completed only if the ride isn't completed -->
<?php if ($ride['status'] !== 'completed'): ?>
  <form method="POST" action="mark_completed.php">
    <input type="hidden" name="ride_id" value="<?= $ride['id'] ?>">
    <button type="submit">Mark as Completed</button>
  </form>
<?php else: ?>
  <!-- Ratings Section shown only after ride is completed -->
  
<?php endif; ?>

    </div>
  <?php endwhile; ?>

  <?php if ($result->num_rows === 0): ?>
    <p>No rides yet.</p>
  <?php endif; ?>

</main>
</body>
</html>
