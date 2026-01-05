<?php
// Database connection using environment variables (for Docker) with fallback to localhost
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASSWORD') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'iec_platform';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Use UTF8MB4 to support emojis and full unicode
$mysqli->set_charset('utf8mb4');

// Backwards compatibility: some files use $conn
$conn = $mysqli;