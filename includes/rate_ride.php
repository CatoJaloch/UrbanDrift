<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ride_id'], $_POST['rating'])) {
  $ride_id = intval($_POST['ride_id']);
  $user_id = $_SESSION['user_id'];
  $rating = floatval($_POST['rating']);
  $feedback = trim($_POST['feedback']);

  $stmt = $conn->prepare("INSERT INTO ride_ratings (ride_id, user_id, rating, feedback) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iids", $ride_id, $user_id, $rating, $feedback);
  if ($stmt->execute()) {
    header("Location: myrides.php?rated=1");
  } else {
    echo "Rating failed.";
  }
  $stmt->close();
}
$conn->close();
?>
