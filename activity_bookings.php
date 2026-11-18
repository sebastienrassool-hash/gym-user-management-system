
<?php
require_once 'config.php';
require_admin();

$conn = db();

// Update booking status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {
    $bookingId = (int) $_POST['booking_id'];
    $status = $_POST['status'];

    if (in_array($status, ['Pending', 'Approved', 'Cancelled'], true)) {
        $stmt = $conn->prepare(
            "UPDATE activity_bookings SET status = ? WHERE id = ?"
        );
        $stmt->bind_param('si', $status, $bookingId);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: activity_bookings.php?updated=1');
    exit;
}

// Get all bookings and member details
$sql = "SELECT
            b.id,
            b.activity_name,
            b.booking_date,
            b.booking_time,
            b.notes,
            b.status,
            b.created_at,
            u.full_name,
            u.username
        FROM activity_bookings b
        INNER JOIN users u ON b.user_id = u.id
        ORDER BY b.booking_date DESC, b.booking_time DESC";

$bookings = $conn->query($sql);

$page_title = 'Activity Bookings';
require 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="fw-bold">Activity Bookings</h1>
        <p class="text-secondary">View and manage member training sessions.</p>
    </div>
    <span class="badge text-bg-success fs-6">
        <?= $bookings->num_rows ?> bookings
    </span>
</div>

<?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Booking status updated successfully.</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php if ($bookings->num_rows > 0): ?>
                    <?php while ($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <strong><?= e($booking['full_name']) ?></strong><br>
                                <small class="text-secondary">
                                    @<?= e($booking['username']) ?>
                                </small>
                            </td>

                            <td><?= e($booking['activity_name']) ?></td>
                            <td><?= e($booking['booking_date']) ?></td>
                            <td><?= date('g:i A', strtotime($booking['booking_time'])) ?></td>
                            <td><?= e($booking['notes'] ?: '—') ?></td>

                            <td>
                                <?php
                                $badge = match ($booking['status']) {
                                    'Approved' => 'text-bg-success',
                                    'Cancelled' => 'text-bg-danger',
                                    default => 'text-bg-warning'
                                };
                                ?>
                                <span class="badge <?= $badge ?>">
                                    <?= e($booking['status']) ?>
                                </span>
                            </td>

                            <td>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="booking_id"
                                           value="<?= (int)$booking['id'] ?>">

                                    <select name="status" class="form-select form-select-sm">
                                        <option value="Pending" <?= $booking['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approved" <?= $booking['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="Cancelled" <?= $booking['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>

                                    <button type="submit" class="btn btn-success btn-sm">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-secondary">
                            No activity bookings found yet.
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
