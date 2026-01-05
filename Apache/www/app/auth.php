<?php
// Apache/www/app/auth.php

// 1. SECURE SESSION SETTINGS (Prevent Cookie Theft)
// Must be set BEFORE session_start()
ini_set('session.cookie_httponly', 1); // JavaScript cannot read the cookie
ini_set('session.use_only_cookies', 1); // No Session IDs in URLs
ini_set('session.cookie_secure', 1);   // Enforce HTTPS (Required for production)
ini_set('session.cookie_samesite', 'Strict'); // Block Cross-Site Request Forgery

session_start();
require_once __DIR__ . '/config.php'; 

/**
 * Handle User Login (SECURE VERSION)
 */
function loginUser($email, $password, $conn) {
    // 2. USE PREPARED STATEMENTS (Prevent SQL Injection)
    // This replaces manual string escaping
    $stmt = $conn->prepare("SELECT id, name, role, password, group_id FROM users WHERE email = ? LIMIT 1");
    if (!$stmt) {
        return "Database error: " . $conn->error;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 3. VERIFY PASSWORD
        if (password_verify($password, $user['password'])) {
            
            // 4. PREVENT SESSION FIXATION (Critical Security Step)
            // Generates a new, random Session ID so hackers can't use an old one
            session_regenerate_id(true);

            // 5. SET SESSION VARIABLES
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['group_id'] = $user['group_id'];
            
            // Fingerprint to prevent hijacking (Optional but recommended)
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            // 6. REDIRECTION LOGIC
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin/dashboard.php");
                    break;
                case 'tutor':
                    header("Location: ../tutor/dashboard.php");
                    break;
                case 'student':
                    header("Location: ../public/student-dashboard.php");
                    break;
                default:
                    header("Location: ../public/sign-in.php?error=invalid_role");
            }
            exit();
        } else {
            return "Incorrect password.";
        }
    } else {
        return "User not found.";
    }
}

/**
 * Security Guard: Role Check
 */
function requireRole($required_role) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/sign-in.php?error=please_login");
        exit();
    }

    // Hijacking Check: Ensure the browser matches the one that logged in
    if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        header("Location: ../public/sign-in.php?error=session_hijacked");
        exit();
    }

    if ($_SESSION['user_role'] !== $required_role) {
        // Log this unauthorized attempt (Logic for later)
        http_response_code(403);
        echo "Access Denied. Required Role: " . htmlspecialchars($required_role);
        exit();
    }
}
?>