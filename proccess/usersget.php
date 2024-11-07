<?php 

$usersFile = 'users.txt';

function getUser() {
    global $usersFile;
    $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $users;
}

header('Content-Type: application/json');

echo json_encode(getUser());


?>