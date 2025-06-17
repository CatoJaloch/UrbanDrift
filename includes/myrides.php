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
include '../includes/navbar.php';
include '../includes/sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Rides</title>
  <link rel="stylesheet" href="../css/myride.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="main-content">
  <h2>Previous Rides</h2>

  <div class="ride-table">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Route</th>
          <th>Passengers</th>
          <th>Rating</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $user_id = $_SESSION['user_id'];
$query = "SELECT * FROM ride_offers WHERE user_id = ? ORDER BY departure_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
        ?>
       <?php if ($result && $result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['departure_date']) ?></td>
      <td><?= htmlspecialchars($row['origin']) ?> → <?= htmlspecialchars($row['destination']) ?></td>
      <td><?= htmlspecialchars($row['seats']) ?></td>
      <td>
        <?php if (!empty($row['rating'])): ?>
          <?= number_format($row['rating'], 1) ?>
        <?php else: ?>
          —
        <?php endif; ?>
      </td>
      <td><a href="ride-details.php?id=<?= $row['id'] ?>" class="view-link">View Details</a></td>
    </tr>
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="5">No rides found.</td></tr>
<?php endif; ?>

      </tbody>
    </table>
  </div>
</div>
</body>
</html>
