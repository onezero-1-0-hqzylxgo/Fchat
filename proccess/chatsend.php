<?php

session_start();


$adminKey = "fuck";

$chatFile = 'chat.txt';

function urlFilter($message){

    $pattern = "/\b(https?:\/\/|www\.)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(\/[^\s]*)?\b/i";

    $filterd_message = preg_replace($pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $message);

    return $filterd_message;
}

function mention($msg) {


    preg_match_all('/@(\w+)/', $msg, $matches);

    if (!empty($matches[1])) {
        
        $file = 'users.txt'; // Path to your users file

        // Read the file line by line
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($matches[1] as $usernameToMention){

            foreach ($lines as $line) {
                // Decode the JSON line into an associative array
                $user = json_decode($line, true);
                
                // Check if the username matches the one to remove
                if ($user['username'] == $usernameToMention) {
                    
                    $mension = "<span style='color: ". $user['color'] .";text-shadow: 0 0 5px ". $user['color'] .",0 0 10px ". $user['color'] .", 0 0 15px ". $user['color'] .", 0 0 100px ". $user['color'] .";'>@". $usernameToMention ."</span>";
                    $mentioned_msg = preg_replace('/@\w+/', $mension, $msg);
                    break;
                    
                }
            }
        }
    }else{
        $mentioned_msg = $msg;
    }
    return $mentioned_msg;

}



function iskicked($userid) {
    $file = 'users.txt'; 
    $tempArray = []; 

   
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


    foreach ($lines as $line) {

        $user = json_decode($line, true);

        if ($user['id'] == $userid && $user['status'] == 'kick') {

            return true;
             
        }
    }

    return false;
}



if(iskicked($_SESSION['id'])){
    header("Location: ../index.php?action=kicked");

}elseif (isset($_SESSION['nickname']) && isset($_POST['message']) && !empty($_POST['message'])) {
    $auther = htmlspecialchars($_SESSION['nickname']);
    if(password_verify($adminKey, $_SESSION['admin'])){
        $auther = $auther . "<span style='font-size: 0.6rem;'>⚡</span>";
    }
    $message = htmlspecialchars($_POST['message']);
    $message = urlFilter($message);
    $message = mention($message);
    $color = htmlspecialchars($_SESSION['color']);
    
    $entry = json_encode([
        "auther" => $auther,
        "message" => $message,
        "color" => $color
    ]) . "\n";

    file_put_contents($chatFile, $entry, FILE_APPEND);
    echo "no";
    header("Location: ../index.php?action=chatbox");

}

?>