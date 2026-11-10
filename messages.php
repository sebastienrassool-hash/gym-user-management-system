
<?php
require_once 'config.php';
require_admin();

$conn = db();

// Delete a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];

    $del = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();

    header('Location: messages.php?deleted=1');
    exit;
}

// Retrieve contact messages
$messages = $conn->query(
    "SELECT * FROM contact_messages ORDER BY created_at DESC"
);

$count = $messages->num_rows;

$page_title = 'Contact Messages';
require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold">Contact Messages</h1>
        <p class="text-secondary">View messages submitted by visitors.</p>
    </div>

    <span class="badge text-bg-success fs-6">
        <?= $count ?> messages
    </span>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">
        Message deleted successfully.
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <?php if ($count > 0): ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['subject']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>

                                <td>
                                    <form method="POST"
                                        onsubmit="return confirm('Delete this message?');">

                                        <input type="hidden" name="delete_id"
                                            value="<?= (int) $row['id'] ?>">

                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        <?php else: ?>

            <div class="text-center p-5">
                <h5>No messages yet</h5>
                <p class="text-secondary">
                    Messages submitted through Contact Us will appear here.
                </p>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
