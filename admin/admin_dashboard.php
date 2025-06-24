
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - UrbanDrift</title>
  <link rel="stylesheet" href="../css/findride.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .dashboard {
      padding: 40px;
      margin-left: 220px;
    }
    .card-grid {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }
    .admin-card {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      flex: 1 1 300px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .admin-card h3 {
      margin-bottom: 10px;
    }
    .admin-card a {
      display: inline-block;
      margin-top: 10px;
      color: purple;
      text-decoration: none;
    }
  </style>
</head>
<body>
<?php include 'admin_sidebar.php'; ?>
<?php include 'admin_navbar.php'; ?>

<div class="dashboard">
  <h2>Welcome, <?= htmlspecialchars($admin_name) ?> </h2>
  <div class="card-grid">
    <div class="admin-card">
      <h3>User Management</h3>
      <p>View and deactivate users.</p>
      <a href="usermanagement.php">Go to User Management</a>
    </div>
    <div class="admin-card">
      <h3>Verification Requests</h3>
      <p>Approve or decline new user verifications.</p>
      <a href="manage_verification.php">Manage Verifications</a>
    </div>
    <div class="admin-card">
      <h3>Log Out</h3>
      <a href="admin_logout.php">Logout</a>
    </div>
  </div>
</div>
</body>
</html>
