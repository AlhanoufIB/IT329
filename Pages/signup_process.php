<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: SignUp.php");
    exit();
}

$first = trim($_POST['FirstName'] ?? '');
$last  = trim($_POST['LastName'] ?? '');
$email = trim($_POST['Email'] ?? '');
$pass  = $_POST['Password'] ?? '';

if ($first === '' || $last === '' || $email === '' || $pass === '') {
    header("Location: SignUp.php?error=missing-fields");
    exit();
}

/* registered check */
$check = $conn->prepare("SELECT UserID FROM user WHERE LOWER(Email) = LOWER(?) LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$checkRes = $check->get_result();

if ($checkRes && $checkRes->num_rows > 0) {
    header("Location: SignUp.php?exists=email-already-registered");
    exit();
}

/* blocked check */
$blocked = $conn->prepare("SELECT 1 FROM blockeduser WHERE LOWER(Email) = LOWER(?) LIMIT 1");
$blocked->bind_param("s", $email);
$blocked->execute();
$blockedRes = $blocked->get_result();

if ($blockedRes && $blockedRes->num_rows > 0) {
    header("Location: SignUp.php?blocked=blocked-user");
    exit();
}

/* image or default */
$photoName = "default.png";

if (isset($_FILES['ProfileImage']) && $_FILES['ProfileImage']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['ProfileImage']['tmp_name'];
    $info = getimagesize($tmp);

    if ($info !== false) {
        $ext = image_type_to_extension($info[2], false);
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if (in_array(strtolower($ext), $allowed, true)) {
            $newName = "profile_" . time() . "_" . rand(1000,9999) . "." . $ext;
            if (move_uploaded_file($tmp, "../images/" . $newName)) {
                $photoName = $newName;
            }
        }
    }
}

/* hash + insert */
$hash = password_hash($pass, PASSWORD_BCRYPT);
$userType = "user";

$ins = $conn->prepare("INSERT INTO user (UserType, FirstName, LastName, Email, Password, ProfilePhoto) VALUES (?, ?, ?, ?, ?, ?)");
$ins->bind_param("ssssss", $userType, $first, $last, $email, $hash, $photoName);

if (!$ins->execute()) {
    header("Location: SignUp.php?error=1");
    exit();
}

/* session */
$_SESSION['UserID'] = $conn->insert_id;
$_SESSION['UserType'] = $userType;
$_SESSION['FirstName'] = $first;
$_SESSION['LastName'] = $last;
$_SESSION['Email'] = $email;
$_SESSION['ProfilePhoto'] = $photoName;

/* redirect */
header("Location: User.php");
exit();