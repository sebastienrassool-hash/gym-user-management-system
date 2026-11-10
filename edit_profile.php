
<?php
require_once 'config.php';
require_login();

$userId = $_SESSION['user_id'];
$success = '';
$error = '';

// Get current account details
$stmt = db()->prepare(
    'SELECT full_name, username, email FROM users WHERE id = ?'
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die('Account not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($fullName === '' || $username === '' || $email === '') {
        $error = 'Please complete all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check whether username or email belongs to another account
        $check = db()->prepare(
            'SELECT id FROM users
             WHERE (username = ? OR email = ?) AND id <> ?'
        );
        $check->bind_param('ssi', $username, $email, $userId);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            $error = 'That username or email is already being used.';
        } else {
            $update = db()->prepare(
                'UPDATE users
                 SET full_name = ?, username = ?, email = ?
                 WHERE id = ?'
            );
            $update->bind_param(
                'sssi',
                $fullName,
                $username,
                $email,
                $userId
            );

            if ($update->execute()) {
                $user['full_name'] = $fullName;
                $user['username'] = $username;
                $user['email'] = $email;
                $success = 'Your profile has been updated successfully.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}

$page_title = 'Edit Profile';
require_once 'includes/header.php';
?>

<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Edit Profile</h2>
        <p class="text-muted">Update your personal account information.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= e($success) ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="full_name"
                           class="form-control" required minlength="3"
                           value="<?= e($user['full_name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username"
                           class="form-control" required minlength="3"
                           value="<?= e($user['username']) ?>">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email"
                           class="form-control" required
                           value="<?= e($user['email']) ?>">
                </div>

                <button type="submit" class="btn btn-success">
                    Save Changes
                </button>

                <a href="account.php" class="btn btn-outline-secondary ms-2">
                    Cancel
                </a>
            </form>

        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
