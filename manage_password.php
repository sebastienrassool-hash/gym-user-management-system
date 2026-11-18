
<?php
require_once 'config.php';
require_admin();

$conn = db();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int)($_POST['user_id'] ?? 0);
    $password = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($userId <= 0) {
        $error = 'Please select a member.';
    } elseif (strlen($password) < 8) {
        $error = 'The new password must contain at least 8 characters.';
    } elseif ($password !== $confirmPassword) {
        $error = 'The passwords do not match.';
    } else {
        // Only allow changing passwords for member accounts
        $check = $conn->prepare(
            "SELECT id FROM users WHERE id = ? AND role = 'member'"
        );
        $check->bind_param('i', $userId);
        $check->execute();
        $member = $check->get_result()->fetch_assoc();
        $check->close();

        if (!$member) {
            $error = 'Member account not found.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $update = $conn->prepare(
                "UPDATE users SET password = ? WHERE id = ? AND role = 'member'"
            );
            $update->bind_param('si', $hashedPassword, $userId);

            if ($update->execute()) {
                $success = 'Member password changed successfully.';
            } else {
                $error = 'Unable to update the password. Please try again.';
            }

            $update->close();
        }
    }
}

$members = $conn->query(
    "SELECT id, full_name, username, email
     FROM users
     WHERE role = 'member'
     ORDER BY full_name ASC"
);

$page_title = 'Manage Member Passwords';
require 'includes/header.php';
?>

<div class="mb-4">
    <h1 class="fw-bold">Manage Member Passwords</h1>
    <p class="text-secondary">
        Set a new password for a registered gym member.
    </p>
</div>

<div class="card border-0 shadow-sm" style="max-width: 650px;">
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
                <label class="form-label">Select Member</label>

                <select name="user_id" class="form-select" required>
                    <option value="">Choose a member</option>

                    <?php while ($member = $members->fetch_assoc()): ?>
                        <option value="<?= (int)$member['id'] ?>">
                            <?= e($member['full_name']) ?>
                            (<?= e($member['username']) ?>)
                        </option>
                    <?php endwhile; ?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input
                    type="password"
                    name="new_password"
                    class="form-control"
                    minlength="8"
                    placeholder="Enter new password"
                    required
                >
                <small class="text-secondary">
                    Minimum 8 characters.
                </small>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <input
                    type="password"
                    name="confirm_password"
                    class="form-control"
                    minlength="8"
                    placeholder="Confirm new password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-success w-100">
                Change Password
            </button>

        </form>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
