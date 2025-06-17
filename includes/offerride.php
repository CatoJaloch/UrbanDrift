<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php"); // redirect to login if not authenticated
  exit;
}
$user_id = $_SESSION['user_id'];
?>

<?php
include '../includes/db.php'; 
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $origin = $_POST['origin'] ?? '';
  $destination = $_POST['destination'] ?? '';
  $departure_date = $_POST['departure_date'] ?? '';
  $departure_time = $_POST['departure_time'] ?? '';
  $return_time = $_POST['return_time'] ?? '';
  $seats = $_POST['seats'] ?? 0;
  $comments = $_POST['comments'] ?? '';

  $sql = "INSERT INTO ride_offers (user_id, origin, destination, departure_date, departure_time, return_time, seats, comments)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


  $stmt = $conn->prepare($sql);
$stmt->bind_param("isssssis", $user_id, $origin, $destination, $departure_date, $departure_time, $return_time, $seats, $comments);

  if ($stmt->execute()) {
    $success = true;
  }

  $stmt->close();
  $conn->close();
}
?>
<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Offer a Ride</title>
<link rel="stylesheet" href="../css/offerride.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div style="margin-left: 220px; padding: 20px">
  <div class="ride-container">
    <h2>Manage Your Rides</h2>
      <?php if ($success): ?>
      <p style="color: green; font-weight: bold;">Your Ride offer saved successfully!</p>
    <?php endif; ?>

    <div class="tab">
      <button class="tab-btn active">Offer Ride</button>
    </div>

    <form class="ride-form"  method="post">
      <div class="form-row">
        <div class="form-group">
          <label><i class="fas fa-map-marker-alt"></i> Origin</label>
          <input type="text" name="origin" placeholder="e.g., karafuke ,county h" required />
        </div>
        <div class="form-group">
          <label><i class="fas fa-location-dot"></i> Destination</label>
          <input type="text" name="destination" placeholder="e.g., University Campus, City B" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label><i class="fas fa-calendar-alt"></i> Date of Departure</label>
          <input type="date" name="departure_date" required />
        </div>
        <div class="form-group">
          <label><i class="fas fa-clock"></i> Time of Departure</label>
          <input type="time" name="departure_time" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label><i class="fas fa-clock"></i> Return Time (Optional)</label>
          <input type="time" name="return_time" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-users"></i> Number of Seats</label>
          <input type="number" name="seats" min="1" max="4" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group full">
          <label><i class="fas fa-comment-alt"></i> Comments</label>
          <textarea name="comments" placeholder="Any special instructions or preferences?"></textarea>
        </div>
      </div>

      <button type="submit" class="submit-btn">Save Ride Offer</button>
    </form>
  </div>
</div>

</body>
</html>
