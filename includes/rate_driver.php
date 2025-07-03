<?php
session_start();
include '../includes/db.php';
include '../includes/navbar.php';
include '../includes/sidebar.php';

$user_id = $_SESSION['user_id'] ?? 0;
$ride_id = intval($_GET['ride_id'] ?? 0);

if (!$ride_id) {
  echo "Invalid ride ID.";
  exit;
}

// Check if this user already rated this ride
$stmt = $conn->prepare("SELECT id FROM ride_ratings WHERE ride_id = ? AND user_id = ?");
$stmt->bind_param("ii", $ride_id, $user_id);
$stmt->execute();
$stmt->store_result();

$hasRated = $stmt->num_rows > 0;
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$hasRated) {
  $rating = intval($_POST['rating']);
  $feedback = trim($_POST['feedback']);

  if ($rating < 1 || $rating > 5) {
    $error = "Invalid rating selected.";
  } else {
    $stmt = $conn->prepare("
      INSERT INTO ride_ratings (ride_id, user_id, rating, feedback, created_at)
      VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("iiis", $ride_id, $user_id, $rating, $feedback);

    if ($stmt->execute()) {
      header("Location: my_bookings.php");
      exit;
    } else {
      $error = "❌ Failed to submit rating.";
    }
    $stmt->close();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rate Driver - UrbanDrift</title>
  <link rel="stylesheet" href="../css/myride.css">
  <style>
    .main-content { margin-left: 220px; padding: 100px 20px; }
    .rating-form {
      max-width: 500px;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin: auto;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .rating-form h2 {
      margin-bottom: 20px;
      font-size: 1.5em;
    }
    .rating-form select,
    .rating-form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .rating-form button {
      background-color: rgb(167, 76, 175);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .rating-form button:hover {
      background-color: #45a049;
    }
    .rating-form .message {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<main class="main-content">
  <div class="rating-form">
    <h2>Rate Your Driver</h2>

    <?php if ($hasRated): ?>
      <p class="message">⚠️ You have already rated this ride.</p>
    <?php elseif (!empty($error)): ?>
      <p class="message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!$hasRated): ?>
    <form method="POST">
      <input type="hidden" name="ride_id" value="<?= htmlspecialchars($ride_id) ?>">

      <label for="rating">Select Rating:</label>
      <select name="rating" required>
        <option value="">Select...</option>
        <?php for ($i=1; $i<=5; $i++): ?>
          <option value="<?= $i ?>"><?= str_repeat('⭐', $i) ?></option>
        <?php endfor; ?>
      </select>

      <label for="feedback">Feedback (optional):</label>
      <textarea name="feedback" rows="4" placeholder="Share any feedback..."></textarea>

      <button type="submit">Submit Rating</button>
    </form>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
