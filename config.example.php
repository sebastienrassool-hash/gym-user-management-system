
<?php
// Example database configuration for FitTrack Gym.
// Copy this file to config.php and update the credentials
// for your own local environment.

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gym_management');

$conn = null;

function db() {
    global $conn;

    if ($conn === null) {
        $conn = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($conn->connect_error) {
            die('Database connection failed.');
        }

        $conn->set_charset('utf8mb4');
    }

    return $conn;
}
