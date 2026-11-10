<?php
require_once 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT id, full_name, username, password, role FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'dashboard.php')); exit;
    }
    $error = 'Incorrect username/email or password.';
}
$page_title = 'Login';
require 'includes/header.php';
?>
<h1 class="fw-bold mb-3">Welcome back</h1>
<?php if (isset($_GET['registered'])): ?><div class="alert alert-success">Registration successful. You can now log in.</div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-card">
  <div class="mb-3"><label class="form-label">Username or email</label><input class="form-control" name="username" required></div>
  <div class="mb-4"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
  <button class="btn btn-success w-100">Login</button>
  <p class="small text-secondary mt-3 mb-0">Demo admin: <strong>admin</strong> / <strong>Admin123!</strong></p>
</form>
<?php require 'includes/footer.php'; ?>
