<?php 

$chatFile = 'chat.txt';

function getMessages() {
    global $chatFile;
    $messages = file($chatFile, FILE_IGNORE_NEW_LINES);
    return $messages;
}

header('Content-Type: application/json');

echo json_encode(getMessages());


?>