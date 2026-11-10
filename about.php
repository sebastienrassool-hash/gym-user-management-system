
<?php
require_once 'config.php';
$page_title = 'About Us';
require_once 'includes/header.php';
?>

<section class="mb-5">
    <div class="p-5 rounded-4 text-white text-center"
         style="background: linear-gradient(135deg, #101820, #198754);">
        <h1 class="display-4 fw-bold">About FitTrack Gym</h1>
        <p class="lead">Stronger Every Day. Better Every You.</p>
        <p>Helping you build strength, confidence and a healthier lifestyle.</p>
    </div>
</section>

<section class="row align-items-center mb-5">
    <div class="col-md-6">
        <h2 class="fw-bold">Who We Are</h2>
        <p>
            FitTrack Gym is a fitness centre dedicated to helping people
            achieve their fitness goals in a welcoming and motivating
            environment.
        </p>
        <p>
            Whether you are a beginner or an experienced athlete,
            we aim to support your journey towards a healthier lifestyle.
        </p>
    </div>

    <div class="col-md-6">
        <img
            src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48"
            class="img-fluid rounded-4 shadow"
            alt="Modern gym interior">
    </div>
</section>

<section class="text-center mb-5">
    <h2 class="fw-bold mb-4">Our Mission</h2>
    <p class="lead">
        To inspire and support every member to become stronger,
        healthier and more confident.
    </p>
</section>

<section class="row text-center g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 p-4 shadow-sm">
            <h4>Our Vision</h4>
            <p>To create a community where everyone can achieve their fitness goals.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 p-4 shadow-sm">
            <h4>Our Values</h4>
            <p>Motivation, dedication, respect and consistency.</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 p-4 shadow-sm">
            <h4>Our Community</h4>
            <p>A supportive environment where every fitness journey matters.</p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
