<?php
require_once 'config.php';
$page_title = 'Welcome';
require 'includes/header.php';
?>
<section class="hero rounded-4 p-4 p-md-5 mb-5">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <span class="badge text-bg-success mb-3">YOUR FITNESS JOURNEY STARTS HERE</span>
      <h1 class="display-4 fw-bold text-white">Stronger every day.</h1>
      <p class="lead text-white-50">Manage your gym membership, keep track of your plan and stay focused on your goals.</p>
      <a class="btn btn-success btn-lg me-2" href="register.php">Become a member</a>
      <a class="btn btn-outline-light btn-lg" href="login.php">Member login</a>
    </div>
  </div>
</section>
<h2 class="fw-bold mb-3">Membership plans</h2>
<div class="row g-4">
  <?php foreach ([
    ['Basic','Access to essential gym facilities','A simple way to get started.'],
    ['Standard','More flexibility for your routine','Great for regular training.'],
    ['Premium','Our complete membership option','For members who want more.']
  ] as $plan): ?>
  <div class="col-md-4"><div class="card plan-card h-100 border-0 shadow-sm">
    <div class="card-body p-4"><h3><?= e($plan[0]) ?></h3><p><?= e($plan[1]) ?></p><p class="text-secondary small"><?= e($plan[2]) ?></p>
    <a href="register.php" class="btn btn-outline-success">Choose plan</a></div>
  </div></div>
  <?php endforeach; ?>
</div>
<?php require 'includes/footer.php'; ?>
