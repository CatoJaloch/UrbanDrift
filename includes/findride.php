<?php 
session_start();
include '../includes/sidebar.php';
include '../includes/navbar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Find a Ride - UrbanDrift</title>
  <link rel="stylesheet" href="../css/findride.css" />
  <style>
    .available-rides-container {
      padding: 20px;
      margin-top: 20px;
      background: #f5f5f5;
      border-radius: 10px;
    }
    .ride-box {
      background: white;
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<main class="main-content">
  <section class="find-ride-container" id="findRide">
    <h2>Find a Ride</h2>
    <form class="find-ride-form" id="rideForm">
      <div class="form-row">
      <div class="form-group" style="position: relative;">
  <label>Pickup Place</label>  
   <input type="text" name="origin" id="origin" placeholder="Enter pickup place" autocomplete="off" /> 
     <div id="origin-suggestions" class="suggestion-dropdown"></div>
</div>
<div class="form-group" style="position: relative;">
   <label>Destination</label>
  <input type="text" name="destination" id="destination" placeholder="Enter destination" autocomplete="off" />
  <div id="destination-suggestions" class="suggestion-dropdown"></div>
</div>

      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Date</label>
          <input type="date" name="departure_date" />
        </div>
        <div class="form-group">
          <label>Pickup Time</label>
<select name="departure_time_range" required>
  <option value="">Select time range</option>
  <option value="6:00-9:00">6:00 AM - 9:00 AM</option>
  <option value="9:00-12:00">9:00 AM - 12:00 PM</option>
  <option value="12:00-15:00">12:00 PM - 3:00 PM</option>
  <option value="15:00-18:00">3:00 PM - 6:00 PM</option>
  <option value="18:00-21:00">6:00 PM - 9:00 PM</option>
</select>

        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Number of Seats</label>
          <select name="seats">
            <option value="">Any</option>
            <option value="1">1 Seat</option>
            <option value="2">2 Seats</option>
            <option value="3">3 Seats</option>
            <option value="4">4 Seats</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group full">
          <label>Comments</label>
          <textarea name="comments" placeholder="Additional preferences or notes..."></textarea>
        </div>
      </div>
      <button type="submit" class="submit-btn">Search Rides</button>
    </form>
  </section>

  <section id="availableRides" class="available-rides-container"></section>
</main>

<script>
document.getElementById('rideForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('../includes/search_rides.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(html => {
    const resultBox = document.getElementById('availableRides');
    resultBox.innerHTML = html;
    resultBox.style.display = 'block';
  })
  .catch(err => {
    console.error("Error:", err);
    document.getElementById('availableRides').innerHTML = "<p>Something went wrong. Please try again.</p>";
  });
});
</script>
<script>

function attachAutocomplete(inputId, dropdownId) {
  const input = document.getElementById(inputId);
  const dropdown = document.getElementById(dropdownId);

  input.addEventListener("input", () => {
    const query = input.value.trim();
    dropdown.innerHTML = "";
    dropdown.style.display = "none";

    if (query.length < 3) return;

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
      .then(res => res.json())
      .then(data => {
        data.features.forEach(place => {
          const name = place.properties.name || '';
          const city = place.properties.city || '';
          const country = place.properties.country || '';
          const label = [name, city, country].filter(Boolean).join(', ');

          const div = document.createElement("div");
          div.textContent = label;

          div.addEventListener("click", () => {
            input.value = label;
            dropdown.innerHTML = "";
            dropdown.style.display = "none";
          });

          dropdown.appendChild(div);
        });

        if (dropdown.children.length > 0) {
          dropdown.style.display = "block";
        }
      })
      .catch(err => console.error("Autocomplete error:", err));
  });

  // Hide suggestions on click outside
  document.addEventListener("click", (e) => {
    if (!dropdown.contains(e.target) && e.target !== input) {
      dropdown.innerHTML = "";
      dropdown.style.display = "none";
    }
  });
  
}

attachAutocomplete("origin", "origin-suggestions");
attachAutocomplete("destination", "destination-suggestions");
</script>
<script>
document.addEventListener('click', function(e) {
  if (e.target.matches('.request-btn')) {
    const form = e.target.closest('.book-ride-form');
    const rideId = form.getAttribute('data-ride-id');
    const msgDiv = document.getElementById(`request-message-${rideId}`);
    
    // ✅ Get the value of seats from the main form
    const seats = document.querySelector('#rideForm select[name="seats"]').value;

    if (!seats || parseInt(seats) <= 0) {
      msgDiv.textContent = '⚠️ Please select number of seats before requesting.';
      msgDiv.style.color = 'red';
      return;
    }

    fetch('book_ride.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams({ 
        ride_id: rideId,
        seats: seats
      })
    })
    .then(res => res.text())
    .then(text => {
      msgDiv.textContent = text;
      msgDiv.style.color = text.toLowerCase().includes('✅') ? 'green' : 'red';
    })
    .catch(err => {
      console.error('Error:', err);
      msgDiv.textContent = '❌ Failed to send request.';
      msgDiv.style.color = 'red';
    });
  }
});

</script>


</body>
</html>
