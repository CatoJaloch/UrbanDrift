<?php 
include '../includes/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Find a Ride - UrbanDrift</title>
  <link rel="stylesheet" href="../css/findride.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="nav-left">
      <div class="logo">🚗</div>
      <span class="site-name">UrbanDrift</span>
      <a href="#" class="nav-link">Dashboard</a>
      <a href="../includes/offerride.php" class="nav-link">Offer Ride</a>
      <a href="#" class="nav-link active">Find Ride</a>
      <a href="#" class="nav-link">My Ride</a>
    </div>
    <div class="nav-right">
      <a href="#" class="nav-link"><i class="fas fa-user"></i> Login/Signup</a>
      <a href="#" class="nav-link"><i class="fas fa-bell"></i></a>
    </div>
  </nav>

  <main class="main-content">
    <!-- Find Ride Form -->
    <section class="find-ride-container" id="findRide">
      <h2>Find a Ride</h2>
      <form class="find-ride-form" id="rideForm">
        <div class="form-row">
          <div class="form-group">
            <label>Destination</label>
            <input type="text" placeholder="Enter destination" required />
          </div>
          <div class="form-group">
            <label>Pickup Place</label>
            <input type="text" placeholder="Enter pickup place" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Date</label>
            <input type="date" required />
          </div>
          <div class="form-group">
            <label>Pickup Time</label>
            <input type="time" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Number of Seats</label>
            <select>
              <option>1 Seat</option>
              <option>2 Seats</option>
              <option>3 Seats</option>
              <option>4 Seats</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group full">
            <label>Comments</label>
            <textarea placeholder="Additional preferences or notes..."></textarea>
          </div>
        </div>
        <button type="button" id="applyFiltersBtn" class="submit-btn">Apply Filters</button>
      </form>
    </section>

    <!-- Available Rides Section -->
    <section class="available-rides-container hidden" id="availableRides">
      <h2>Available Rides</h2>
      <div class="rides-grid">
        <!-- Ride example -->
        <div class="ride-box">
          <p><strong>From:</strong> Downtown</p>
          <p><strong>To:</strong> City Center</p>
          <p><strong>Date:</strong> 2025-06-17</p>
          <p><strong>Time:</strong> 08:00 AM</p>
          <p><strong>Seats Available:</strong> 2</p>
          <p><strong>Comments:</strong> No smoking, please.</p>
        </div>
        <!-- Add more ride-boxes dynamically or manually -->
      </div>
    </section>
  </main>

  <script>
    const applyBtn = document.getElementById('applyFiltersBtn');
    const findRideContainer = document.querySelector('.find-ride-container');
    const availableRides = document.querySelector('.available-rides-container');

    applyBtn.addEventListener('click', () => {
      findRideContainer.classList.add('slide-out');
      availableRides.classList.remove('hidden');
      availableRides.classList.add('slide-in');
    });
  </script>
</body>
</html>
