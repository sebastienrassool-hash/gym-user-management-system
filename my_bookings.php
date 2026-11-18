
<?php
require_once 'config.php';
require_login();

// Only members can view their bookings
if (($_SESSION['role'] ?? '') !== 'member') {
    header('Location: admin.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];

$stmt = db()->prepare(
    "SELECT activity_name, booking_date, booking_time, notes, status
     FROM activity_bookings
     WHERE user_id = ?
     ORDER BY booking_date DESC, booking_time DESC"
);

$stmt->bind_param('i', $userId);
$stmt->execute();
$bookings = $stmt->get_result();

$page_title = 'My Appointments';
require 'includes/header.php';
?>

<div class="mb-4">
    <h1 class="fw-bold">My Appointments</h1>
    <p class="text-secondary">
        View your booked gym activities and appointment status.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($bookings->num_rows > 0): ?>

                    <?php while ($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= e($booking['activity_name']) ?>
                            </td>

                            <td>
                                <?= date('d M Y', strtotime($booking['booking_date'])) ?>
                            </td>

                            <td>
                                <?= date('g:i A', strtotime($booking['booking_time'])) ?>
                            </td>

                            <td>
                                <?= e($booking['notes'] ?: '—') ?>
                            </td>

                            <td>
                                <?php
                                if ($booking['status'] === 'Approved') {
                                    $badge = 'text-bg-success';
                                } elseif ($booking['status'] === 'Cancelled') {
                                    $badge = 'text-bg-danger';
                                } else {
                                    $badge = 'text-bg-warning';
                                }
                                ?>

                                <span class="badge <?= $badge ?>">
                                    <?= e($booking['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-center py-4 text-secondary">
                            You have not booked any activities yet.
                        </td>
                    </tr>

                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$stmt->close();
require 'includes/footer.php';
?>
