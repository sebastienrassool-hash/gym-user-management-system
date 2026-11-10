
<?php
require_once 'config.php';
require_login();

// Get the logged-in user's details
$stmt = db()->prepare(
    'SELECT full_name, username, email, role FROM users WHERE id = ?'
);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die('Account not found.');
}

// Get membership details if the user is a member
$membership = null;

if ($user['role'] === 'member') {
    $stmt = db()->prepare(
        'SELECT plan_name, start_date, end_date, status
         FROM memberships
         WHERE user_id = ?
         ORDER BY id DESC LIMIT 1'
    );
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

    $membership = $stmt->get_result()->fetch_assoc();
}

$page_title = 'My Account';
require_once 'includes/header.php';
?>

<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">My Account</h2>
        <p class="text-muted">View your personal account information.</p>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-person-circle text-success"
                   style="font-size: 70px;"></i>
                <h4 class="mt-2"><?= e($user['full_name']) ?></h4>
                <span class="badge bg-success">
                    <?= e(ucfirst($user['role'])) ?>
                </span>
            </div>

            <h5 class="fw-bold mb-3">Personal Information</h5>

            <p><strong>Full Name:</strong>
                <?= e($user['full_name']) ?></p>

            <p><strong>Username:</strong>
                <?= e($user['username']) ?></p>

            <p><strong>Email Address:</strong>
                <?= e($user['email']) ?></p>

            <p><strong>Account Type:</strong>
                <?= e(ucfirst($user['role'])) ?></p>
        </div>
    </div>

    <?php if ($user['role'] === 'member'): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Membership Information</h5>

                <?php if ($membership): ?>
                    <p><strong>Membership Plan:</strong>
                        <?= e($membership['plan_name']) ?></p>

                    <p><strong>Start Date:</strong>
                        <?= e($membership['start_date']) ?></p>

                    <p><strong>Expiry Date:</strong>
                        <?= e($membership['end_date']) ?></p>

                    <p><strong>Status:</strong>
                        <?= e(ucfirst($membership['status'])) ?></p>
                <?php else: ?>
                    <p class="text-muted">
                        No membership information is available.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

   <div class="mt-4">
    <a href="edit_profile.php" class="btn btn-success">
        <i class="bi bi-pencil-square me-1"></i> Edit Profile
    </a>

    <a href="<?= $user['role'] === 'admin' ? 'admin.php' : 'dashboard.php' ?>"
       class="btn btn-outline-secondary ms-2">
        Back to Dashboard
    </a>
</div>
</div>

<?php require_once 'includes/footer.php'; ?>
