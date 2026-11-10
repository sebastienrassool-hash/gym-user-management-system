<?php
require_once 'config.php';
if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $plan = $_POST['plan'] ?? 'Basic';

    if ($name === '') $errors[] = 'Please enter your full name.';
    if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) $errors[] = 'Username must be 3–50 characters and contain only letters, numbers or underscores.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Password must contain at least 8 characters.';
    if (!in_array($plan, ['Basic','Standard','Premium'], true)) $errors[] = 'Please choose a valid plan.';

    if (!$errors) {
        $conn = db();
        $check = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $check->bind_param('ss', $username, $email);
        $check->execute();
        if ($check->get_result()->num_rows) {
            $errors[] = 'That username or email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, 'member')");
            $stmt->bind_param('ssss', $name, $username, $email, $hash);
            if ($stmt->execute()) {
                $userId = $stmt->insert_id;
                $start = date('Y-m-d');
                $end = date('Y-m-d', strtotime('+1 month'));
                $m = $conn->prepare("INSERT INTO memberships (user_id, plan_name, start_date, end_date, status) VALUES (?, ?, ?, ?, 'Active')");
                $m->bind_param('isss', $userId, $plan, $start, $end);
                $m->execute();
                header('Location: login.php?registered=1'); exit;
            } else $errors[] = 'Registration could not be completed.';
        }
    }
}
$page_title = 'Register';
require 'includes/header.php';
?>
<h1 class="fw-bold mb-3">Create your membership</h1>
<?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="form-card needs-validation" novalidate>
  <div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="full_name" required value="<?= e($_POST['full_name'] ?? '') ?>"><div class="invalid-feedback">Enter your full name.</div></div>
  <div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" required minlength="3" value="<?= e($_POST['username'] ?? '') ?>"><div class="invalid-feedback">Enter a username (at least 3 characters).</div></div>
  <div class="mb-3"><label class="form-label">Email address</label><input class="form-control" type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"><div class="invalid-feedback">Enter a valid email.</div></div>
  <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required minlength="8"><div class="form-text">At least 8 characters.</div><div class="invalid-feedback">Use at least 8 characters.</div></div>
  <div class="mb-4"><label class="form-label">Membership plan</label><select class="form-select" name="plan" id="planSelect" required><option value="Basic">Basic</option><option value="Standard">Standard</option><option value="Premium">Premium</option></select><div class="form-text" id="planHint">Basic plan selected.</div></div>
  <button class="btn btn-success w-100" type="submit">Register</button>
</form>
<?php require 'includes/footer.php'; ?>
