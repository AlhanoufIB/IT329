<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Login.php");
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$loginType = $_POST['loginType'] ?? 'user';

if ($email === '' || $password === '') {
    header("Location: Login.php?error=1");
    exit();
}

/* blocked check by email */
$blockedStmt = $conn->prepare("SELECT 1 FROM blockeduser WHERE LOWER(Email) = LOWER(?) LIMIT 1");
$blockedStmt->bind_param("s", $email);
$blockedStmt->execute();
$blockedResult = $blockedStmt->get_result();

if ($blockedResult && $blockedResult->num_rows > 0) {
    header("Location: Login.php?blocked=1");
    exit();
}

/* get user */
$stmt = $conn->prepare("SELECT UserID, UserType, FirstName, LastName, Email, Password, ProfilePhoto FROM user WHERE LOWER(Email) = LOWER(?) LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows !== 1) {
    header("Location: Login.php?error=1");
    exit();
}

$user = $result->fetch_assoc();

/* verify password */
if (!password_verify($password, $user['Password'])) {
    header("Location: Login.php?error=1");
    exit();
}

/* role check */
if (strtolower($loginType) !== strtolower($user['UserType'])) {
    header("Location: Login.php?error=1");
    exit();
}

/* session */
$_SESSION['UserID'] = (int)$user['UserID'];
$_SESSION['UserType'] = $user['UserType'];
$_SESSION['FirstName'] = $user['FirstName'];
$_SESSION['LastName'] = $user['LastName'];
$_SESSION['Email'] = $user['Email'];
$_SESSION['ProfilePhoto'] = $user['ProfilePhoto'];

/* redirect */
if (strtolower($user['UserType']) === 'admin') {
    header("Location: Admin.php");
} else {
    header("Location: User.php");
}
exit();