<?php

$adminKey = "fuck";

$adminpassword = $adminKey;

session_start(); // Start the session

function systemmsg($message="SYTEM - You cant kick yourself!"){
    $chatFile = "proccess/chat.txt";
    $auther = htmlspecialchars($_SESSION['nickname']);
    $color = htmlspecialchars($_SESSION['color']);
    
    $entry = json_encode([
        "auther" => "sytem",
        "message" => $message,
        "color" => "#00fff3"
    ]) . "\n";

    file_put_contents($chatFile, $entry, FILE_APPEND);
}




// Function to remove user from users.txt
function removeUserFromFile($userid) {
    $file = 'proccess/users.txt'; // Path to your users file
    $tempArray = []; // Array to hold the modified contents

    // Read the file line by line
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Loop through each line
    foreach ($lines as $line) {
        // Decode the JSON line into an associative array
        $user = json_decode($line, true);

        // Check if the username matches the one to remove
        if ($user['id'] !== $userid) {
            $tempArray[] = $line; // Add the line to the temporary array if it doesn't match
        }
    }

    // Write the new contents back to the file
    file_put_contents($file, implode(PHP_EOL, $tempArray) . PHP_EOL);
}

function kick($userid) {
    $file = 'proccess/users.txt'; // Path to your users file
    $tempArray = []; // Array to hold the modified contents

    // Read the file line by line
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Loop through each line
    foreach ($lines as $line) {
        // Decode the JSON line into an associative array
        $user = json_decode($line, true);

        // Check if the username matches the one to remove
        if ($user['id'] == $userid) {
            if(password_verify("njdasdni1j23njdisnaij",$user['admin'])){
                systemmsg("SYTEM - Cant kick @".$user['username']." => [ADMIN]");
            }else{
                systemmsg("SYTEM - @".$user['username']." was kicked");
                $user['status'] = 'kick';
            }
            // Encode the modified user back to JSON
            $line = json_encode($user); // Convert back to JSON format
        }
        $tempArray[] = $line; // Add the line to the temporary array if it doesn't match
    }

    // Write the new contents back to the file
    file_put_contents($file, implode(PHP_EOL, $tempArray) . PHP_EOL);
}




if (isset($_GET['user'])) {

    $user = $_GET['user'];
    if($user == $_SESSION['id']){
        
        systemmsg();
        header("Location: index.php?action=userslist");

    }elseif(password_verify($adminpassword, $_SESSION['admin'])){

        kick($user);
        header("Location: index.php?action=userslist");

    }else{
        removeUserFromFile($user);
    
        // Clear the session and log out
        session_unset();
        session_destroy();
        
        // Redirect or show a message
        echo "You have successfully logged out. you tried to hack";
        header("Location: login.php");
    }
    

}elseif(isset($_SESSION['id'])) {

    $userid = $_SESSION['id'];
    
    // Remove the user from the file
    removeUserFromFile($userid);
    
    // Clear the session and log out
    session_unset();
    session_destroy();
    
    // Redirect or show a message
    echo "You have successfully logged out.";
    header("Location: login.php");
}else{
    header("Location: login.php");
}


