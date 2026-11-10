
<?php
require_once 'config.php';
$page_title = 'Activities';
require_once 'includes/header.php';
?>

<section class="text-center p-5 rounded-4 text-white mb-5"
    style="background: linear-gradient(135deg, #101820, #198754);">
    <h1 class="display-4 fw-bold">Our Activities</h1>
    <p class="lead">Discover new ways to stay active and strong.</p>
</section>

<section class="row g-4 mb-5">

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Weight training">
            <div class="card-body">
                <h4>Weight Training</h4>
                <p>Build strength and develop your muscles with our range of strength training equipment.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Cardio training">
            <div class="card-body">
                <h4>Cardio Training</h4>
                <p>Improve your stamina and fitness with activities such as running and cycling.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Fitness and flexibility">
            <div class="card-body">
                <h4>Group Fitness</h4>
                <p>Stay motivated and enjoy exercising with others in a supportive environment.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Personal training">
            <div class="card-body">
                <h4>Personal Training</h4>
                <p>Work towards your individual goals with focused training and guidance.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Yoga">
            <div class="card-body">
                <h4>Yoga & Flexibility</h4>
                <p>Improve flexibility, balance and relaxation through movement and stretching.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48"
                 class="card-img-top" style="height:220px; object-fit:cover;"
                 alt="Gym facilities">
            <div class="card-body">
                <h4>Gym Workouts</h4>
                <p>Enjoy access to a variety of gym equipment and spaces for your workouts.</p>
            </div>
        </div>
    </div>

</section>

<?php require_once 'includes/footer.php'; ?>
