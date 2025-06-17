<!-- Navbar -->
<nav class="navbar">
  <div class="nav-left">
    <div class="logo">🚗</div>
    <span class="site-name">UrbanDrift</span>
    <a href="../includes/dashboard.php" class="nav-link">Dashboard</a>
    <a href="../includes/offerride.php" class="nav-link">Offer Ride</a>
    <a href="../includes/findride.php" class="nav-link">Find Ride</a>
    <a href="../includes/myrides.php" class="nav-link">My Rides</a>
    <a href="../includes/logout.php" class="nav-link">Logout</a>
  </div>
  <div class="nav-right">
    <a href="../includes/signup.php" class="nav-link"><i class="fas fa-user"></i> Login/Signup</a>
    <a href="#" class="nav-link"><i class="fas fa-bell"></i></a>
  </div>
</nav>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Navbar Styles -->
<style>
  .navbar {
    position: fixed;
    top: 0;
    width: 97%;
    background-color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 2rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    z-index: 1000;
  }

  .nav-left, .nav-right {
    display: flex;
    align-items: center;
    gap: 1.2rem;
  }

  .logo {
    font-size: 1.6rem;
    color: purple;
  }

  .site-name {
    font-size: 1.2rem;
    font-weight: bold;
    color: black;
  }

  .nav-link {
    text-decoration: none;
    color: black;
    font-size: 0.95rem;
    transition: color 0.3s;
  }

  .nav-link:hover {
    color: purple;
  }
</style>
