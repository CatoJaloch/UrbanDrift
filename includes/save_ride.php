<?php
echo "Session User ID: " . ($_SESSION['user_id'] ?? 'Not Set') . "<br>";

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}
$user_id = $_SESSION['user_id'];

include 'db.php'; 


$origin = $_POST['origin'] ?? '';
$destination = $_POST['destination'] ?? '';
$departure_date = $_POST['departure_date'] ?? '';
$departure_time = $_POST['departure_time'] ?? '';
$return_time = $_POST['return_time'] ?? '';
$seats = $_POST['seats'] ?? 0;
$comments = $_POST['comments'] ?? '';


$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO ride_offers (user_id, origin, destination, departure_date, departure_time, return_time, seats, comments)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssis", $user_id, $origin, $destination, $departure_date, $departure_time, $return_time, $seats, $comments);

if ($stmt->execute()) {
  echo "<h3>Ride saved successfully!</h3><a href='includes/offerride.php'>Back to Offer Ride</a>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
