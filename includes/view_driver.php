<?php
session_start();
include '../includes/db.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$driver_id = intval($_GET['driver_id'] ?? 0);

// Fetch driver info + vehicle
$stmt = $conn->prepare("
  SELECT u.name, u.email, u.gender, u.age,u.car_capacity, u.car_model, u.license_plate
  FROM users u
  WHERE u.id = ?
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($name, $email, $gender, $age, $car_capacity, $car_model, $license_plate);
$stmt->fetch();
$stmt->close();

// Fetch average rating
$stmt = $conn->prepare("
  SELECT AVG(rating_by_passenger) 
  FROM ride_offers 
  WHERE user_id = ? AND rating_by_passenger IS NOT NULL
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$stmt->bind_result($avg_rating);
$stmt->fetch();
$stmt->close();

// Fetch feedback
$stmt = $conn->prepare("
  SELECT r.feedback_by_passenger, u.name AS reviewer 
  FROM ride_offers r
  JOIN ride_bookings b ON r.id = b.ride_id
  JOIN users u ON b.user_id = u.id
  WHERE r.user_id = ? AND r.rating_by_passenger IS NOT NULL AND r.feedback_by_passenger != ''
  ORDER BY r.id DESC
");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$feedback_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Profile – UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    .main-content { margin-left: 220px; padding: 80px 20px 20px; display: flex; gap: 30px; }
    .profile-box { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ccc; flex: 1; }
    .feedback-box { background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; flex: 1; max-height: 500px; overflow-y: auto; }
    .feedback-entry { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
    .rating { font-weight: bold; color: #333; }
  </style>
</head>
<body>

<main class="main-content">
  <div class="profile-box">
    <h2><?= htmlspecialchars($name) ?>'s Profile</h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
    <p><strong>Average Rating:</strong> <?= $avg_rating ? "⭐ " . round($avg_rating,1) . "/5" : "Not rated yet" ?></p>
    <hr>
    <h3>Vehicle Details</h3>
    <p><strong>Type:</strong> <?= $car_capacity ? htmlspecialchars($car_capacity) : "Not provided" ?></p>
    <p><strong>Model:</strong> <?= $car_model ? htmlspecialchars($car_model) : "Not provided" ?></p>
    <p><strong>License Plate:</strong> <?= $license_plate ? htmlspecialchars($license_plate) : "Not provided" ?></p>
  </div>

  <div class="feedback-box">
    <h3>Passenger Comments</h3>
    <?php if ($feedback_result->num_rows > 0): ?>
      <?php while ($row = $feedback_result->fetch_assoc()): ?>
        <div class="feedback-entry">
          <p><em>"<?= htmlspecialchars($row['feedback_by_passenger']) ?>"</em></p>
          <p class="rating">– <?= htmlspecialchars($row['reviewer']) ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No feedback available.</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
