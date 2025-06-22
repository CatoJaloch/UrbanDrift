<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
  $image = $_FILES['profile_image'];
  $filename = time() . "_" . basename($image['name']);
  $targetDir = "../uploads/";
  $targetFile = $targetDir . $filename;

  if (move_uploaded_file($image['tmp_name'], $targetFile)) {
    $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
    $stmt->bind_param("si", $filename, $user_id);
    $stmt->execute();
    $stmt->close();
  } else {
    echo "❌ Error uploading file.";
    exit;
  }
}

$conn->close();
header("Location: profile.php");
exit;

ini_set('display_errors', 1);
error_reporting(E_ALL);
