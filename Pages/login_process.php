<?php
// login_process.php
session_start();
include 'db_connect.php';

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

$stmt = $conn->prepare("SELECT UserID, UserType, FirstName, LastName, Email, Password FROM `user` WHERE Email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows !== 1) {
    header("Location: Login.php?error=1");
    exit();
}

$user = $result->fetch_assoc();


if (!password_verify($password, $user['Password'])) {
    header("Location: Login.php?error=2");
    exit();
}


if (strtolower($loginType) !== strtolower($user['UserType'])) {
    // Example: user tries "Login as Admin" with a user account
    header("Location: Login.php?error=3");
    exit();
}


$_SESSION['UserID'] = (int)$user['UserID'];
$_SESSION['UserType'] = $user['UserType'];
$_SESSION['FirstName'] = $user['FirstName'];
$_SESSION['LastName'] = $user['LastName'];
$_SESSION['Email'] = $user['Email'];

// 5) redirect
if (strtolower($user['UserType']) === 'admin') {
    header("Location: Admin.php");
} else {
    header("Location: User.php");
}
exit();
?>