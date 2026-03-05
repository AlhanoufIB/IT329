<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: SignUp.php");
  exit();
}

$first = trim($_POST['FirstName'] ?? '');
$last  = trim($_POST['LastName'] ?? '');
$email = trim($_POST['Email'] ?? '');
$pass  = $_POST['Password'] ?? '';

if ($first === '' || $last === '' || $email === '' || $pass === '') {
  header("Location: SignUp.php");
  exit();
}


$check = $conn->prepare("SELECT UserID FROM `user` WHERE Email = ? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$checkRes = $check->get_result();

if ($checkRes && $checkRes->num_rows > 0) {
  header("Location: SignUp.php?exists=1");
  exit();
}

$hash = password_hash($pass, PASSWORD_BCRYPT);

if (isset($_FILES['ProfileImage']) && $_FILES['ProfileImage']['error'] === UPLOAD_ERR_OK) {
  $tmp = $_FILES['ProfileImage']['tmp_name'];


  $info = getimagesize($tmp);
  if ($info !== false) {
    $ext = image_type_to_extension($info[2], false); // jpg/png/gif/webp
    $allowed = ['jpg','jpeg','png','gif','webp'];

    if (in_array(strtolower($ext), $allowed)) {
      $newName = "profile_" . time() . "_" . rand(1000,9999) . "." . $ext;
      move_uploaded_file($tmp, "images/" . $newName);
    }
  }
}


$userType = "user";

$ins = $conn->prepare("INSERT INTO `user` (UserType, FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?, ?)");
$ins->bind_param("sssss", $userType, $first, $last, $email, $hash);
$ins->execute();

/* 5) Redirect to login */
header("Location: Login.php");
exit();