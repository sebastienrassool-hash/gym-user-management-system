<?php
require_once 'config.php'; require_login();
$stmt = db()->prepare('SELECT plan_name, start_date, end_date, status FROM memberships WHERE user_id = ? ORDER BY id DESC LIMIT 1');
$stmt->bind_param('i', $_SESSION['user_id']); $stmt->execute();
$membership = $stmt->get_result()->fetch_assoc();
$page_title = 'Member dashboard'; require 'includes/header.php';
?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4"><div><h1 class="fw-bold">Hello, <?= e($_SESSION['full_name']) ?>!</h1><p class="text-secondary mb-0">Here is your membership overview.</p></div><span class="badge text-bg-success fs-6">Member account</span></div>
<div class="row g-3">
  <div class="col-md-4"><div class="stat-card"><small>Membership plan</small><h3><?= e($membership['plan_name'] ?? 'Not assigned') ?></h3></div></div>
  <div class="col-md-4"><div class="stat-card"><small>Membership status</small><h3><?= e($membership['status'] ?? 'Not assigned') ?></h3></div></div>
  <div class="col-md-4"><div class="stat-card"><small>Expiry date</small><h3><?= e($membership['end_date'] ?? '—') ?></h3></div></div>
</div>
<div class="alert alert-info mt-4">If your membership details need updating, please contact the gym administrator.</div>
<?php require 'includes/footer.php'; ?>
