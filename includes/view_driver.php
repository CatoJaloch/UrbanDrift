<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$driver_id = intval($_GET['driver_id'] ?? 0);

// Get driver profile
$stmt = $conn->prepare("SELECT name, email, car_model, license_plate FROM users WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$driver = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Get ratings
$stmt = $conn->prepare("
  SELECT rr.rating, rr.feedback, rr.created_at, u.name AS passenger_name
  FROM ride_ratings rr
  JOIN users u ON rr.user_id = u.id
  WHERE rr.ride_id IN (SELECT id FROM ride_offers WHERE user_id = ?)
  ORDER BY rr.created_at DESC
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Profile</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-content {
      margin-left: 220px;
      padding: 60px 30px;
      max-width: 800px;
    }

    h2, h3 {
      color: #333;
      border-bottom: 2px solid #ccc;
      padding-bottom: 5px;
    }

    .profile-box, .ratings-box {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .profile-box p, .ratings-box p {
      margin: 8px 0;
      font-size: 15px;
    }

    .ratings-box {
      border-left: 4px solid #4caf50;
    }

    .ratings-box p strong {
      font-weight: 600;
    }

    .ratings-box p em {
      color: #555;
      display: block;
      margin-top: 5px;
    }

    .ratings-box p:last-child {
      font-size: 0.85em;
      color: #777;
    }
  </style>
</head>
<body>
<main class="main-content">
  <h2>Driver Profile</h2>
  <?php if ($driver): ?>
    <div class="profile-box">
      <p><strong>Name:</strong> <?= htmlspecialchars($driver['name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($driver['email']) ?></p>
      <p><strong>Car Model:</strong> <?= htmlspecialchars($driver['car_model']) ?></p>
      <p><strong>License Plate:</strong> <?= htmlspecialchars($driver['license_plate']) ?></p>
    </div>

    <h3>Passenger Ratings & Feedback</h3>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="ratings-box">
          <p><strong><?= htmlspecialchars($row['passenger_name']) ?>:</strong> ⭐ <?= $row['rating'] ?>/5</p>
          <p><em><?= htmlspecialchars($row['feedback']) ?></em></p>
          <p><?= $row['created_at'] ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No ratings yet.</p>
    <?php endif; ?>
  <?php else: ?>
    <p>Driver not found.</p>
  <?php endif; ?>
  <button onclick="history.back()" style="
  background-color: #3498db;
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 5px;
  font-size: 14px;
  cursor: pointer;
  margin-bottom: 15px;
">
  ← Back to Find Rides
</button>

</main>
</body>
</html>
