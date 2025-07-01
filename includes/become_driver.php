<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];
include '../includes/db.php';

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $license_plate = $_POST['license_plate'] ?? '';
  $car_model = $_POST['car_model'] ?? '';
  $car_capacity = $_POST['car_capacity'] ?? 0;

  $stmt = $conn->prepare("UPDATE users SET is_driver = 1, license_plate = ?, car_model = ?, car_capacity = ? WHERE id = ?");
  $stmt->bind_param("ssii", $license_plate, $car_model, $car_capacity, $user_id);

  if ($stmt->execute()) {
    $success = true;
  }

  $stmt->close();
}
?>

<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Become a Driver</title>
  <link rel="stylesheet" href="../css/become_driver.css" />
</head>
<body>
  <div class="main-content">
    <h2>Register as a Driver</h2>
    <?php if ($success): ?>
      <p class="success-msg">✅ You are now registered as a driver.</p>
    <?php endif; ?>

    <form method="post" class="driver-form">
      <div class="form-group">
        <label>Car Model</label>
        <input type="text" name="car_model" required placeholder="e.g., Toyota Corolla" />
      </div>

      <div class="form-group">
        <label>License Plate</label>
        <input type="text" name="license_plate" required placeholder="e.g., KAA 123A" />
      </div>

      <div class="form-group">
        <label>Number of Seats</label>
        <input type="number" name="car_capacity" min="1" max="8" required />
      </div>

      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>
</body>
</html>
 