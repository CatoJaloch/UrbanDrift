<?php
session_start();
include '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$signup_success = false;
$signup_error = '';
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $gender = trim($_POST['gender']);
  $dob = $_POST['dob'];
  $house_number = trim($_POST['house_number']);
  $password_raw = $_POST['password'];
  $password = password_hash($password_raw, PASSWORD_DEFAULT);
  $estate_id = intval($_POST['estate_id']);
  $age = date_diff(date_create($dob), date_create('today'))->y;$age = date_diff(date_create($dob), date_create('today'))->y;

  if (empty($name) || empty($email) || empty($password_raw) || empty($house_number) || empty($estate_id) || empty($gender) || empty($dob)) {
    $signup_error = "Please fill in all required fields.";
  } elseif ($age < 18) {
    $signup_error = "You must be at least 18 years old to register.";
  } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password_raw)) {
    $signup_error = "Password must be at least 8 characters long, include uppercase, lowercase, digit, and special character.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $signup_error = "Email is already registered.";
    } else {
     $stmt_insert = $conn->prepare("
  INSERT INTO users (name, email, password, gender, dob, age, house_number, estate_id, is_verified, verification_requested_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())
");
$stmt_insert->bind_param("ssssssii", $name, $email, $password, $gender, $dob, $age, $house_number, $estate_id);

      if ($stmt_insert->execute()) {
        $signup_success = true;
      } else {
        $signup_error = "Signup failed. Please try again.";
      }
      $stmt_insert->close();
    }
    $stmt->close();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
  $email = trim($_POST['login_email']);
  $password = $_POST['login_password'];

  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $verify = $conn->prepare("SELECT is_verified FROM users WHERE id = ?");
      $verify->bind_param("i", $user['id']);
      $verify->execute();
      $verify->bind_result($is_verified);
      $verify->fetch();
      $verify->close();

      if (!$is_verified) {
        $login_error = "⏳ Your account is pending verification by the estate admin.";
      } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
      }
    } else {
      $login_error = "Incorrect password.";
    }
  } else {
    $login_error = "No account found with that email.";
  }
  $stmt->close();
}

$estate_result = $conn->query("SELECT id, name FROM estates");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>UrbanDrift Signup / Login</title>
  <link rel="stylesheet" href="../css/signup.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div style="margin-left: 220px; padding: 40px;">
  <div class="container" id="container">

    <div class="form-container sign-up-container">
      <form method="post" action="">
        <h1>Create Account</h1>
        <?php if ($signup_success): ?>
          <p style="color:green;">✅ Account created! Await admin verification.</p>
        <?php elseif ($signup_error): ?>
          <p style="color:red;"><?php echo $signup_error; ?></p>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" id="password"
               title="Min 8 chars, include upper, lower, digit & special char" required />
        <div id="password-hint"></div>

        <select name="gender" required>
          <option value="">Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" placeholder="Date of Birth" required />
        <div id="age-warning" style="color: red; display: none;">You must be at least 18 years old to register.</div>

        <input type="text" name="house_number" placeholder="House Number" required />

        <select name="estate_id" required>
          <option value="">Select Estate</option>
          <?php while ($estate = $estate_result->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($estate['id']) ?>"><?= htmlspecialchars($estate['name']) ?></option>
          <?php endwhile; ?>
        </select>

        <button type="submit" name="signup">Sign Up</button>
      </form>
    </div>

    <div class="form-container sign-in-container">
      <form method="post" action="">
        <h1>Sign In</h1>
        <?php if ($login_error): ?>
          <p style="color:red;"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <input type="email" name="login_email" placeholder="Email" required />
        <input type="password" name="login_password" placeholder="Password" required />
        <button type="submit" name="login">Sign In</button>
      </form>
    </div>

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Already have an account?</h2>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>New here?</h2>
          <a href="../admin/admin_signup.php" class="admin-link">Admin Signup</a>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
const container = document.getElementById('container');
document.getElementById('signUp').onclick = () => container.classList.add("right-panel-active");
document.getElementById('signIn').onclick = () => container.classList.remove("right-panel-active");

const passwordInput = document.getElementById('password');
const hint = document.getElementById('password-hint');

passwordInput.addEventListener('input', function () {
  const value = passwordInput.value;
  let messages = [];

  if (value.length < 8) messages.push("Min 8 chars");
  if (!/[A-Z]/.test(value)) messages.push("Uppercase needed");
  if (!/[a-z]/.test(value)) messages.push("Lowercase needed");
  if (!/\d/.test(value)) messages.push("Digit needed");
  if (!/[\W_]/.test(value)) messages.push("Special char needed");

  hint.textContent = messages.length === 0 ? "" : messages.join(". ") + ".";
});

document.getElementById('dob').addEventListener('input', function () {
  const dob = new Date(this.value);
  const today = new Date();
  const age = today.getFullYear() - dob.getFullYear();
  const m = today.getMonth() - dob.getMonth();
  const isUnderage = m < 0 || (m === 0 && today.getDate() < dob.getDate()) ? age - 1 < 18 : age < 18;

  const warning = document.getElementById('age-warning');
  warning.style.display = isUnderage ? 'block' : 'none';
});
</script>

</body>
</html>
