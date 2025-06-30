<?php
include '../includes/db.php';

$conditions = [];
$params = [];
$types = "";

// Add filters
if (!empty($_POST['destination'])) {
  $conditions[] = "r.destination LIKE ?";
  $params[] = "%" . $_POST['destination'] . "%";
  $types .= "s";
}
if (!empty($_POST['origin'])) {
  $conditions[] = "r.origin LIKE ?";
  $params[] = "%" . $_POST['origin'] . "%";
  $types .= "s";
}
if (!empty($_POST['departure_date'])) {
  $conditions[] = "r.departure_date = ?";
  $params[] = $_POST['departure_date'];
  $types .= "s";
}
if (!empty($_POST['seats'])) {
  $conditions[] = "r.seats >= ?";
  $params[] = $_POST['seats'];
  $types .= "i";
}

// Build query
$sql = "
  SELECT r.*, u.name AS driver_name,
    (SELECT AVG(rating_by_passenger) FROM ride_offers WHERE user_id = r.user_id AND rating_by_passenger IS NOT NULL) AS driver_rating
  FROM ride_offers r
  JOIN users u ON r.user_id = u.id
";
if (!empty($conditions)) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
  die("SQL prepare error: " . $conn->error);
}

if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($ride = $result->fetch_assoc()) {
    echo "<div class='ride-box'>";
    echo "<p><strong>From:</strong> " . htmlspecialchars($ride['origin']) . "</p>";
    echo "<p><strong>To:</strong> " . htmlspecialchars($ride['destination']) . "</p>";
    echo "<p><strong>Date:</strong> " . $ride['departure_date'] . "</p>";
    echo "<p><strong>Time:</strong> " . $ride['departure_time'] . "</p>";
    echo "<p><strong>Seats:</strong> " . $ride['seats'] . "</p>";
    echo "<p><strong>Driver:</strong> " . htmlspecialchars($ride['driver_name']) . "</p>";
    echo "<p><strong>Driver Rating:</strong> " . 
         ($ride['driver_rating'] ? "⭐ " . round($ride['driver_rating'], 1) . "/5" : "Not rated yet") . 
         "</p>";

    echo "<a href='view_driver.php?driver_id=" . $ride['user_id'] . "' class='btn-view'>View Driver Details</a>";

    // Request button
    echo "<form class='book-ride-form' data-ride-id='" . $ride['id'] . "'>";
    echo "<button type='button' class='request-btn'>Request Seat</button>";
    echo "</form>";
    echo "<div class='request-message' id='request-message-" . $ride['id'] . "'></div>";

    echo "</div>";
  }
} else {
  echo "<p>No matching rides found.</p>";
}

$stmt->close();
$conn->close();
?>
