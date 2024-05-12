<?php
include_once 'functions.php';

// Starts Session, if there is no active Session
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}



if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: index.php");
    die();
}



if (!isset($_POST['action']) || ($_POST['action'] != 'signup' && $_POST['action'] != 'login')) {
    header("Location: index.php");
    die();
}




$_SESSION['msgs'] = [];

// signup

// Part 1 Signup

if ($_POST['action'] == 'signup') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);



    // Check if the inputs are not set or empty, and append the error msg to the SESSION msm array, echos the errors


    if (checkIfEmpty($username) || checkIfEmpty($email) || checkIfEmpty($_POST['password'])) {
    }


    // Username, password and email validations, append msgs to session array for the error, and sets the SESSION status to error

    checkUsername($username);
    checkPassword($_POST['password']);
    checkEmailLenght($email);


    // If any of the validations fail, the SESSION status is set to error, and the following code in the if statment executes




    // Uses the getAllUsers function to get all the users for the txt files, and creates an array on every new line.
    $allUsers = getAllUsers();
    $allUsers = explode(PHP_EOL, $allUsers);


    // Creates the user to be saved for the first part, where we needed to save just the username and hased password.
    $userToSave = "$username=$password";

    // Creates the user to be saved for the second part, where we needed to save the email, username and password.
    $userToSave1 = "$email, $username=$password";

    foreach ($allUsers as $users) {

        [$usernamePost, $passwordHash] = explode("=", $users);

        if ($usernamePost == $username && $usernamePost !== "") {
            $_SESSION['status'] = 'error';
            array_push($_SESSION['msgs'], 'Username taken');
        }
    }


    $allUsersStorage = file_get_contents("./storage.txt");
    $allUsersStorage = trim($allUsersStorage);
    $allUsersStorage = explode(PHP_EOL, $allUsersStorage);

    foreach ($allUsersStorage as $test) {
        [$emailStorage, $holder] = explode(",", $test);

        if ($email == $emailStorage && $email !== "") {
            $_SESSION['status'] = 'error';
            $_SESSION['emailTaken'] = 'A user with this email already exists';
        }
    }


    if ($_SESSION['status'] == 'error') {
        header('Location: ./signup.php');
        die();
    }


    // Inputs the user into Storage with the format ‘email, username=password’.

    if (file_put_contents("./storage.txt", $userToSave1 . PHP_EOL, FILE_APPEND)) {
        $_SESSION['status'] = 'success';
    }

    // Inputs the user into users.txt in the format "username=password".

    if (file_put_contents("./users.txt", $userToSave . PHP_EOL, FILE_APPEND)) {
        $_SESSION['status'] = 'success';
        $_SESSION['username'] = $username;
        header("Location: main.php");
        die();
    }
}


// login

if ($_POST['action'] == 'login') {

    $usernamePost = $_POST['username'];
    $password = $_POST['password'];

    $allUsers = getAllUsers();
    $allUsers = explode(PHP_EOL, $allUsers);

    foreach ($allUsers as $users) {

        [$username, $passwordHash] = explode("=", $users);

        if (strtolower($usernamePost) == strtolower($username) && password_verify($password, $passwordHash)) {
            $_SESSION['username'] = $username;
            header("Location: main.php?$username");
            die();
        }
    }

    $_SESSION['status'] = 'error';
    array_push($_SESSION['msgs'], 'Wrong username/password combination.');
    header("Location: login.php");
    die();
}
