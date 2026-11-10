<?php
require_once 'config.php'; require_admin();
$conn = db();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    if ($id !== (int)$_SESSION['user_id']) {
        $del = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'member'");
        $del->bind_param('i', $id); $del->execute();
    }
    header('Location: admin.php?deleted=1'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_membership'])) {
    $id = (int)$_POST['user_id']; $plan = $_POST['plan'] ?? 'Basic'; $status = $_POST['status'] ?? 'Active'; $end = $_POST['end_date'] ?? date('Y-m-d');
    if (in_array($plan, ['Basic','Standard','Premium'], true) && in_array($status, ['Active','Expired','Cancelled'], true)) {
        $up = $conn->prepare('UPDATE memberships SET plan_name=?, status=?, end_date=? WHERE user_id=?');
        $up->bind_param('sssi', $plan, $status, $end, $id); $up->execute();
    }
    header('Location: admin.php?updated=1'); exit;
}
$members = $conn->query("SELECT u.id, u.full_name, u.username, u.email, u.created_at, m.plan_name, m.start_date, m.end_date, m.status
FROM users u LEFT JOIN memberships m ON m.user_id=u.id WHERE u.role='member' ORDER BY u.id DESC");
$count = $members->num_rows;
$page_title = 'Admin dashboard'; require 'includes/header.php';
?>
<div class="d-flex justify-content-between flex-wrap align-items-center mb-4"><div><h1 class="fw-bold">Admin dashboard</h1><p class="text-secondary mb-0">Manage registered gym members.</p></div><span class="badge text-bg-success fs-6"><?= $count ?> members</span></div>
<?php if (isset($_GET['deleted'])): ?><div class="alert alert-success">Member deleted.</div><?php endif; ?>
<?php if (isset($_GET['updated'])): ?><div class="alert alert-success">Membership updated.</div><?php endif; ?>
<div class="card border-0 shadow-sm"><div class="card-body">
<div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Plan</th><th>Status</th><th>Expiry</th><th>Actions</th></tr></thead><tbody>
<?php while ($member = $members->fetch_assoc()): ?>
<tr><td><?= e($member['full_name']) ?></td><td><?= e($member['username']) ?></td><td><?= e($member['email']) ?></td><td><?= e($member['plan_name'] ?? '—') ?></td><td><span class="badge <?= ($member['status'] ?? '') === 'Active' ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= e($member['status'] ?? '—') ?></span></td><td><?= e($member['end_date'] ?? '—') ?></td><td class="text-nowrap">
<button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#edit<?= (int)$member['id'] ?>">Edit</button>
<form method="post" class="d-inline" onsubmit="return confirm('Delete this member?');"><input type="hidden" name="delete_id" value="<?= (int)$member['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form>
</td></tr>
<div class="modal fade" id="edit<?= (int)$member['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="post">
<div class="modal-header"><h5 class="modal-title">Edit membership</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body"><input type="hidden" name="user_id" value="<?= (int)$member['id'] ?>">
<label class="form-label">Plan</label><select class="form-select mb-3" name="plan"><?php foreach(['Basic','Standard','Premium'] as $p): ?><option <?= ($member['plan_name']===$p?'selected':'') ?>><?= $p ?></option><?php endforeach; ?></select>
<label class="form-label">Status</label><select class="form-select mb-3" name="status"><?php foreach(['Active','Expired','Cancelled'] as $s): ?><option <?= ($member['status']===$s?'selected':'') ?>><?= $s ?></option><?php endforeach; ?></select>
<label class="form-label">Expiry date</label><input class="form-control" type="date" name="end_date" value="<?= e($member['end_date'] ?? date('Y-m-d')) ?>" required></div>
<div class="modal-footer"><button class="btn btn-success" name="update_membership" value="1">Save changes</button></div></form></div></div></div>
<?php endwhile; ?>
<?php if ($count === 0): ?><tr><td colspan="7" class="text-center text-secondary py-4">No members registered yet.</td></tr><?php endif; ?>
</tbody></table></div></div></div>
<?php require 'includes/footer.php'; ?>
