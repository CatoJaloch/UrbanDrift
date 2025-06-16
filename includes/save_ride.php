<?php
include 'db.php'; 


$origin = $_POST['origin'] ?? '';
$destination = $_POST['destination'] ?? '';
$departure_date = $_POST['departure_date'] ?? '';
$departure_time = $_POST['departure_time'] ?? '';
$return_time = $_POST['return_time'] ?? '';
$seats = $_POST['seats'] ?? 0;
$comments = $_POST['comments'] ?? '';


$sql = "INSERT INTO ride_offers (origin, destination, departure_date, departure_time, return_time, seats, comments)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssis", $origin, $destination, $departure_date, $departure_time, $return_time, $seats, $comments);

if ($stmt->execute()) {
  echo "<h3>Ride saved successfully!</h3><a href='includes/offerride.php'>Back to Offer Ride</a>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
