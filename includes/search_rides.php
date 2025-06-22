<?php
include '../includes/db.php';

$conditions = [];
$params = [];
$types = "";

// Check and add filters
if (!empty($_POST['destination'])) {
  $conditions[] = "destination LIKE ?";
  $params[] = "%" . $_POST['destination'] . "%";
  $types .= "s";
}
if (!empty($_POST['origin'])) {
  $conditions[] = "origin LIKE ?";
  $params[] = "%" . $_POST['origin'] . "%";
  $types .= "s";
}
if (!empty($_POST['departure_date'])) {
  $conditions[] = "departure_date = ?";
  $params[] = $_POST['departure_date'];
  $types .= "s";
}
if (!empty($_POST['departure_time'])) {
  $conditions[] = "departure_time = ?";
  $params[] = $_POST['departure_time'];
  $types .= "s";
}
if (!empty($_POST['seats'])) {
  $conditions[] = "seats >= ?";
  $params[] = $_POST['seats'];
  $types .= "i";
}

// Build the SQL
$sql = "SELECT * FROM ride_offers";
if (!empty($conditions)) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

// Bind parameters if any
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
  echo "<p><strong>Comments:</strong> " . htmlspecialchars($ride['comments']) . "</p>";

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
