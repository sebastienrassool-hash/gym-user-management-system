
<?php
require_once 'config.php';
require_login();

// Only members can book activities
if (($_SESSION['role'] ?? '') !== 'member') {
    header('Location: activities.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $activity = trim($_POST['activity_name'] ?? '');
    $date = $_POST['booking_date'] ?? '';
    $time = $_POST['booking_time'] ?? '';
    $notes = trim($_POST['notes'] ?? '');

    if ($activity === '' || $date === '' || $time === '') {
        $error = 'Please complete all required fields.';
    } elseif ($date < date('Y-m-d')) {
        $error = 'Please select a future date.';
    } else {

        $stmt = db()->prepare(
            "INSERT INTO activity_bookings
            (user_id, activity_name, booking_date, booking_time, notes)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            'issss',
            $_SESSION['user_id'],
            $activity,
            $date,
            $time,
            $notes
        );

        if ($stmt->execute()) {
            header('Location: activities.php?booking=success');
            exit;
        } else {
            $error = 'Unable to save your booking. Please try again.';
        }

        $stmt->close();
    }
}

if ($error !== '') {
    echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
}
?>
