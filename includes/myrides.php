<?php
include '../includes/db.php';
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
        $query = "SELECT * FROM ride_offers ORDER BY departure_date DESC";
        $result = $conn->query($query);

        if ($result->num_rows > 0):
          while($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['departure_date']) ?></td>
          <td><?= htmlspecialchars($row['origin']) ?> → <?= htmlspecialchars($row['destination']) ?></td>
          <td><?= htmlspecialchars($row['seats']) ?></td>
          <td>
            <?php if ($row['rating']): ?>
               <?= number_format($row['rating'], 1) ?>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
          <td><a href="ride-details.php?id=<?= $row['id'] ?>" class="view-link">View Details</a></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="5">No rides found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
