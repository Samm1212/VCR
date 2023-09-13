<?php
session_start();
include '../backend/db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$role = $_POST['role'];
$allGood = true;

if (empty($username)) {
    $allGood = false;
    header ("Location: signup.php?error=Please enter your username");
    exit();
} else if (empty($password)) {
    $allGood = false;
    header ("Location: signup.php?error=Please enter your password");
    exit();
} else if (empty($fullname)) {
    $allGood = false;
    header ("Location: signup.php?error=Please enter your full name");
    exit();
}

$fullnameLength = strlen($fullname);
$usernameLength = strlen($username);
$passwordLength = strlen($password);

if ($fullnameLength > 25) {
    $allGood = false;
    header ("Location: signup.php?error=The full name is too long");
    exit();
} else if ($usernameLength > 20) {
    $allGood = false;
    header ("Location: signup.php?error=The username can't be longer than 20 characters");
    exit();
} else if ($passwordLength > 20) {
    $allGood = false;
    header ("Location: signup.php?error=Password can't be longer than 20 characters");
    exit();
}

function checkFullname($fullname) {
    $pattern = '/^[A-Za-z\s\'-]+$/';

    return preg_match($pattern, $fullname);
}

function checkUsername($username) {
    include '../backend/db_connection.php';
    $sql = "select * from users where username = '$username';";
    $res = $conn->query($sql);
    $numRows = mysqli_num_rows($res);
    if ($numRows > 0) {
        $check = false;
    } else {
        $check = true;
    }
    return $check;
}

function checkRole($role) {
    include '../backend/db_connection.php';
    $check = true;
    if ($role == "admin") {
        $sql = "select * from users where role = 'admin';";
        $res = $conn->query($sql);
        $numRows = mysqli_num_rows($res);
        if ($numRows > 0) {
            $check = false;
        }
    }
    return $check;
}

$fullnameLC = checkFullname($fullname);
$usernameLC = checkUsername($username);
$roleCheck = checkRole($role);

if (!$fullnameLC) {
    $allGood = false;
    header ("Location: signup.php?error=Please enter a valid name");
    exit();
} else if (!$usernameLC) {
    $allGood = false;
    header ("Location: signup.php?error=This username is already taken");
    exit();
} else if (!$roleCheck) {
    $allGood = false;
    header ("Location: signup.php?error=An admin already exist");
    exit();
}

if ($allGood) {
    $sql = "insert into users(username, password, fullName, role) values ('$username', '$password', '$fullname', '$role');";
    $res = $conn->query($sql);
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    header ("Location: home.php");
    exit();
} else {
    header ("Location: signup.php?error=One or more entries need revision");
    exit();
}


?>