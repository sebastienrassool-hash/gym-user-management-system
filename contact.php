
<?php
require_once 'config.php';

$page_title = 'Contact Us';

$successMessage = '';
$errorMessage = '';

$name = '';
$email = '';
$subject = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        $errorMessage = 'Please complete all fields.';
    } elseif (strlen($name) < 3) {
        $errorMessage = 'Your name must contain at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid email address.';
    } elseif (strlen($subject) < 3) {
        $errorMessage = 'Your subject must contain at least 3 characters.';
    } elseif (strlen($message) < 10) {
        $errorMessage = 'Your message must contain at least 10 characters.';
    } elseif (strlen($name) > 100 || strlen($email) > 150 || strlen($subject) > 150) {
        $errorMessage = 'One or more fields are too long.';
    } else {
        $stmt = db()->prepare(
            "INSERT INTO contact_messages (name, email, subject, message)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param('ssss', $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $successMessage = 'Thank you! Your message has been sent successfully.';

            $name = '';
            $email = '';
            $subject = '';
            $message = '';
        } else {
            $errorMessage = 'Sorry, something went wrong. Please try again.';
        }

        $stmt->close();
    }
}

require_once 'includes/header.php';
?>

<section class="text-center p-5 rounded-4 text-white mb-5"
    style="background: linear-gradient(135deg, #101820, #198754);">
    <h1 class="display-4 fw-bold">Contact Us</h1>
    <p class="lead">We're here to help you on your fitness journey.</p>
</section>

<section class="row g-4 mb-5">

    <div class="col-md-5">
        <div class="h-100 p-4 rounded-4 text-white"
            style="background:#101820;">

            <h2 class="fw-bold mb-4">Get in Touch</h2>

            <p>Have a question or feedback? We'd love to hear from you.</p>

            <hr>

            <h5>Our Location</h5>
            <p>FitTrack Gym | Seychelles | Providence</p>

            <h5>Email</h5>
            <p>info@fittrackgym.com</p>

            <h5>Opening Hours</h5>
            <p>Monday – Saturday</p>
            <p>8:00 AM – 9:00 PM</p>

            <h5>Contact us on:</h5>
            <p>(+248) 4224616</p>

        </div>
    </div>

    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-4">

            <h2 class="fw-bold mb-3">Send Us a Message</h2>
            <p class="text-muted">Fill in the form below and share your feedback.</p>

            <?php if ($successMessage): ?>
                <div class="alert alert-success">
                    <?= e($successMessage) ?>
                </div>
            <?php endif; ?>

            <?php if ($errorMessage): ?>
                <div class="alert alert-danger">
                    <?= e($errorMessage) ?>
                </div>
            <?php endif; ?>

            <form id="contactForm" class="needs-validation"
                  method="POST" action="" novalidate>

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control"
                        placeholder="Enter your name"
                        value="<?= e($name) ?>"
                        minlength="3" maxlength="100" required>
                    <div class="invalid-feedback">
                        Please enter a name with at least 3 characters.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="Enter your email"
                        value="<?= e($email) ?>"
                        maxlength="150" required>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control"
                        placeholder="What is your message about?"
                        value="<?= e($subject) ?>"
                        minlength="3" maxlength="150" required>
                    <div class="invalid-feedback">
                        Please enter a subject with at least 3 characters.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Your Message</label>
                    <textarea name="message" class="form-control" rows="5"
                        minlength="10" required
                        placeholder="Write your message here..."><?= e($message) ?></textarea>
                    <div class="invalid-feedback">
                        Please enter a message with at least 10 characters.
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Send Message
                </button>

            </form>

        </div>
    </div>

</section>

<?php require_once 'includes/footer.php'; ?>
