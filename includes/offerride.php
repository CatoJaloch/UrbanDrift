<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: signup.php");
  exit;
}

$user_id = $_SESSION['user_id'];
include '../includes/db.php';

// Check if user is a driver
$stmt = $conn->prepare("SELECT is_driver FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_driver);
$stmt->fetch();
$stmt->close();

if (!$is_driver) {
  $_SESSION['message'] = "⚠️ Only registered drivers can access this page.";
  header("Location: become_driver.php");
  exit;
}

$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $origin = $_POST['origin'] ?? '';
  $destination = $_POST['destination'] ?? '';
  $departure_date = $_POST['departure_date'] ?? '';
  $departure_time = $_POST['departure_time'] ?? '';
  $return_time = $_POST['return_time'] ?? '';
  $seats = $_POST['seats'] ?? 0;
  $comments = $_POST['comments'] ?? '';

  $sql = "INSERT INTO ride_offers (user_id, origin, destination, departure_date, departure_time, return_time, seats, comments)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssssis", $user_id, $origin, $destination, $departure_date, $departure_time, $return_time, $seats, $comments);

  if ($stmt->execute()) {
    $success = true;
  }

  $stmt->close();
  $conn->close();
}
?>

<?php include '../includes/navbar.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Offer a Ride</title>
<!-- Include jQuery, Typeahead, and Photon plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.2/typeahead.bundle.min.js"></script>
<script src="https://unpkg.com/typeahead-address-photon/dist/bundle.js"></script>
<link rel="stylesheet" href="https://unpkg.com/typeahead-address-photon/dist/bundle.css">

<link rel="stylesheet" href="../css/offerride.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div style="margin-left: 220px; padding: 20px">
  <div class="ride-container">
    <h2>Manage Your Rides</h2>
      <?php if ($success): ?>
      <p style="color: green; font-weight: bold;">Your Ride offer saved successfully!</p>
    <?php endif; ?>

    <div class="tab">
      <button class="tab-btn active">Offer Ride</button>
    </div>

    <form class="ride-form"  method="post">
      <div class="form-row">
    <div class="form-group" style="position: relative;">
  <label><i class="fas fa-map-marker-alt"></i> Origin</label>
  <input type="text" id="origin" name="origin" placeholder="Enter origin" autocomplete="off">
  <div id="origin-suggestions" class="suggestion-dropdown"></div>
</div>

<div class="form-group" style="position: relative;">
  <label><i class="fas fa-location-dot"></i> Destination</label>
  <input type="text" id="destination" name="destination" placeholder="Enter destination" autocomplete="off">
  <div id="destination-suggestions" class="suggestion-dropdown"></div>
</div>

      

      <div class="form-row">
        <div class="form-group">
          <label><i class="fas fa-calendar-alt"></i> Date of Departure</label>
          <input type="date" name="departure_date" required />
        </div>
        <div class="form-group">
          <label><i class="fas fa-clock"></i> Time of Departure</label>
          <input type="time" name="departure_time" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label><i class="fas fa-clock"></i> Return Time (Optional)</label>
          <input type="time" name="return_time" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-users"></i> Number of Seats</label>
          <input type="number" name="seats" min="1" max="4" required />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group full">
          <label><i class="fas fa-comment-alt"></i> Comments</label>
          <textarea name="comments" placeholder="Any special instructions or preferences?"></textarea>
        </div>
      </div>

      <button type="submit" class="submit-btn">Save Ride Offer</button>
    </form>
  </div>
</div>
<script>
function setupAutocomplete(inputId, dropdownId) {
  const input = document.getElementById(inputId);
  const dropdown = document.getElementById(dropdownId);

  input.addEventListener("input", function () {
    const query = input.value.trim();
    dropdown.innerHTML = "";
    dropdown.style.display = "none";

    if (query.length < 3) return;

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
      .then(res => res.json())
      .then(data => {
        data.features.forEach(place => {
          const item = document.createElement("div");
          const name = place.properties.name || "";
          const city = place.properties.city || "";
          const country = place.properties.country || "";
          item.textContent = `${name}, ${city}, ${country}`.replace(/^, |, ,/g, '').trim();
          item.onclick = () => {
            input.value = item.textContent;
            dropdown.innerHTML = "";
            dropdown.style.display = "none";
          };
          dropdown.appendChild(item);
        });

        if (dropdown.children.length > 0) {
          dropdown.style.display = "block";
        }
      })
      .catch(err => console.error("Autocomplete error:", err));
  });

  // Hide suggestions when clicking outside
  document.addEventListener("click", function (e) {
    if (!dropdown.contains(e.target) && e.target !== input) {
      dropdown.innerHTML = "";
      dropdown.style.display = "none";
    }
  });
}

setupAutocomplete("origin", "origin-suggestions");
setupAutocomplete("destination", "destination-suggestions");
</script>



</body>
</html>
