<?php
include '../includes/db.php';

$conditions = [];
$params = [];
$types = "";

// Collect filters from the form
if (!empty($_POST['destination'])) {
  $conditions[] = "ro.destination LIKE ?";
  $params[] = "%" . $_POST['destination'] . "%";
  $types .= "s";
}
if (!empty($_POST['origin'])) {
  $conditions[] = "ro.origin LIKE ?";
  $params[] = "%" . $_POST['origin'] . "%";
  $types .= "s";
}
if (!empty($_POST['departure_date'])) {
  $conditions[] = "ro.departure_date = ?";
  $params[] = $_POST['departure_date'];
  $types .= "s";
}
if (!empty($_POST['seats'])) {
  $conditions[] = "ro.seats >= ?";
  $params[] = $_POST['seats'];
  $types .= "i";
}

// Build the query
$sql = "
  SELECT ro.*, 
         u.name AS driver_name,
         COALESCE(AVG(rated.rating_by_passenger), 0) AS avg_rating
  FROM ride_offers ro
  JOIN users u ON ro.user_id = u.id
  LEFT JOIN ride_offers rated ON rated.user_id = ro.user_id AND rated.rating_by_passenger IS NOT NULL
";

// Apply filters
if (!empty($conditions)) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " GROUP BY ro.id";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($ride = $result->fetch_assoc()) {
    echo "<div class='ride-box'>";
    echo "<p><strong>Driver:</strong> " . htmlspecialchars($ride['driver_name']) . "</p>";
    echo "<p><strong>From:</strong> " . htmlspecialchars($ride['origin']) . "</p>";
    echo "<p><strong>To:</strong> " . htmlspecialchars($ride['destination']) . "</p>";
    echo "<p><strong>Date:</strong> " . $ride['departure_date'] . "</p>";
    echo "<p><strong>Time:</strong> " . $ride['departure_time'] . "</p>";
    echo "<p><strong>Seats:</strong> " . $ride['seats'] . "</p>";
    echo "<p><strong>Comments:</strong> " . htmlspecialchars($ride['comments']) . "</p>";
    echo "<p><strong>Driver Rating:</strong> ⭐ " . number_format($ride['avg_rating'], 1) . " / 5</p>";

    echo "<form method='post' action='book_ride.php'>";
    echo "<input type='hidden' name='ride_id' value='" . $ride['id'] . "' />";
    echo "<button type='submit'>Request Seat</button>";
    echo "</form>";

    echo "</div>";
  }
} else {
  echo "<p>No matching rides found.</p>";
}

$stmt->close();
$conn->close();
?>
