<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

function getAllUsers()
{
    $allUsers = file_get_contents("./users.txt");
    $allUsers = trim($allUsers);
    return $allUsers;
}

function checkIfEmpty($data)
{


    if (empty($data)) {
        $_SESSION['status'] = 'error';
        array_push($_SESSION['msgs'], "No empty fields are allowed");
        return true;
    }
}


function checkUsername($username)
{


    if (preg_match("/[\s!@#$%^&*()\-_=+{};:,<.>]/", $username)) {
        $_SESSION['status'] = 'error';
        array_push($_SESSION['msgs'], 'Username cannot contain empty spaces or special signs;');
        return true;
    }
}

function checkPassword($password)
{

    if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*()\-_=+{};:,<.>])(?=.*[A-Z]).*$/", $password)) {
        $_SESSION['status'] = 'error';
        array_push($_SESSION['msgs'], 'Password must have at least one number, one special sign and one uppercase letter;');
        return true;
    }
}


function checkEmailLenght($email)
{
    $lenghtEmail = explode("@", $email);

    if (strlen($lenghtEmail[0]) < 5) {
        $_SESSION['status'] = 'error';
        array_push($_SESSION['msgs'], 'Email must have at least 5 characters before @');
        return true;
    }
}
