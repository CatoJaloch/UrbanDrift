<?php
include '../includes/db.php';

$conditions = [];
$params = [];
$types = "";

// Filters
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
  $requested_seats = intval($_POST['seats']);
} else {
  $requested_seats = 1;
}

// Query
$sql = "
  SELECT 
    r.*, 
    u.name AS driver_name,
    COALESCE((
      SELECT AVG(rr.rating) 
      FROM ride_ratings rr 
      WHERE rr.ride_id = r.id
    ), 0) AS driver_rating,
    COALESCE((
      SELECT SUM(b.seats_requested)
      FROM ride_bookings b
      WHERE b.ride_id = r.id AND b.status = 'accepted'
    ), 0) AS seats_booked
  FROM ride_offers r
  JOIN users u ON r.user_id = u.id
";

if (!empty($conditions)) {
  $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("SQL error: " . $conn->error);
}

if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($ride = $result->fetch_assoc()) {
    $available_seats = $ride['seats'] - $ride['seats_booked'];

    echo "<div class='ride-box'>";
    echo "<p><strong>From:</strong> " . htmlspecialchars($ride['origin']) . "</p>";
    echo "<p><strong>To:</strong> " . htmlspecialchars($ride['destination']) . "</p>";
    echo "<p><strong>Date:</strong> " . htmlspecialchars($ride['departure_date']) . "</p>";
    echo "<p><strong>Time:</strong> " . htmlspecialchars($ride['departure_time']) . "</p>";
    echo "<p><strong>Total Seats:</strong> " . $ride['seats'] . "</p>";
    echo "<p><strong>Available Seats:</strong> " . $available_seats . "</p>";
    echo "<p><strong>Driver:</strong> " . htmlspecialchars($ride['driver_name']) . "</p>";
    echo "<p><strong>Driver Rating:</strong> " . 
         ($ride['driver_rating'] ? "⭐ " . round($ride['driver_rating'], 1) . "/5" : "Not rated yet") . 
         "</p>";

    echo "<a href='view_driver.php?driver_id=" . $ride['user_id'] . "' class='btn-view'>View Driver Details</a>";

    if ($available_seats >= $requested_seats) {
      echo "<form class='book-ride-form' data-ride-id='" . $ride['id'] . "'>";
      echo "<input type='hidden' name='seats' value='" . $requested_seats . "' />";
      echo "<button type='button' class='request-btn'>Request $requested_seats Seat" . ($requested_seats > 1 ? "s" : "") . "</button>";
      echo "</form>";
    } else {
      echo "<p style='color: red; font-weight: bold;'>❌ Not enough seats for your request.</p>";
    }

    echo "<div class='request-message' id='request-message-" . $ride['id'] . "'></div>";
    echo "</div>";
  }
} else {
  echo "<p>No matching rides found.</p>";
}

$stmt->close();
$conn->close();
?>
