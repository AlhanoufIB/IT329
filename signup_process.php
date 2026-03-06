<?php
session_start();
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: SignUp.php");
    exit();
}

$first = trim($_POST["FirstName"] ?? "");
$last  = trim($_POST["LastName"] ?? "");
$email = trim($_POST["Email"] ?? "");
$pass  = $_POST["Password"] ?? "";

if ($first === "" || $last === "" || $email === "" || $pass === "") {
    header("Location: SignUp.php?error=1");
    exit();
}

/* 1) Blocked check (by email) */
$bstmt = $conn->prepare("SELECT 1 FROM blockeduser WHERE Email = ? LIMIT 1");
$bstmt->bind_param("s", $email);
$bstmt->execute();
$bRes = $bstmt->get_result();
if ($bRes && $bRes->num_rows > 0) {
    header("Location: SignUp.php?blocked=1");
    exit();
}

/* 2) Email exists check */
$chk = $conn->prepare("SELECT 1 FROM user WHERE Email = ? LIMIT 1");
$chk->bind_param("s", $email);
$chk->execute();
$chkRes = $chk->get_result();
if ($chkRes && $chkRes->num_rows > 0) {
    header("Location: SignUp.php?exists=1");
    exit();
}

/* 3) Insert user */
$hashed = password_hash($pass, PASSWORD_DEFAULT);
$userType = "user";

$ins = $conn->prepare("INSERT INTO user (UserType, FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?, ?)");
$ins->bind_param("sssss", $userType, $first, $last, $email, $hashed);

if (!$ins->execute()) {
    header("Location: SignUp.php?error=1");
    exit();
}

/* 4) Auto-login + redirect */
$_SESSION["user_id"]   = $conn->insert_id;
$_SESSION["user_type"] = "user";

header("Location: User.php");
exit();