<?php session_start();
include '../includes/db.php';
include '../includes/navbar.php';
include '../includes/sidebar.php';

$user_id = $_SESSION['user_id'] ?? 0;
$ride_id = intval($_GET['ride_id'] ?? 0);

if (!$ride_id) {
  echo "Invalid ride ID.";
  exit;
}

// Fetch existing rating (optional)
$stmt = $conn->prepare("SELECT rating_by_passenger, feedback_by_passenger FROM ride_offers WHERE id = ? AND user_id != ?");
$stmt->bind_param("ii", $ride_id, $user_id); // Assuming the passenger is not the ride creator
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();
$stmt->close();

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $rating = intval($_POST['rating']);
  $feedback = trim($_POST['feedback']);

  $stmt = $conn->prepare("
    UPDATE ride_offers
    SET rating_by_passenger = ?, feedback_by_passenger = ?
    WHERE id = ? AND rating_by_passenger IS NULL
  ");
  $stmt->bind_param("isi", $rating, $feedback, $ride_id);
  $stmt->execute();
  $stmt->close();

  header("Location: my_bookings.php");
  exit;
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
      background-color:rgb(167, 76, 175);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .rating-form button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<main class="main-content">
  <div class="rating-form">
    <h2>Rate Your Driver</h2>
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
  </div>
</main>

</body>
</html>
