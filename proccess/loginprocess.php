<?php

session_start([
    'cookie_lifetime' => 0,
    'cookie_httponly' => true, 
    'cookie_secure' => true, 
]);

$userFile = "users.txt";

if(isset($_SESSION['nickname']) && $_SESSION['color']){
    header("Location: ../index.php");
}

function isColorNearBlack($hexColor) {
    // Remove the hash (#) if it's present
    $hexColor = ltrim($hexColor, '#');

    // Check if the hex color is valid (6 characters)
    if (strlen($hexColor) !== 6) {
        return false; // Invalid color
    }

    // Convert hex to RGB
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Define a threshold (e.g., 50)
    $threshold = 50;

    // Check if the RGB values are all below the threshold
    return ($r < $threshold && $g < $threshold && $b < $threshold);
}



if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $nickname = $_POST['nickname'];
    $adminpassword = $_POST['admin'] ?? "none";
    $color = $_POST['color'];

    function sanitizeNickname($input, $type) {

        if($type == "name") {
            return preg_match('/[;\'"\\/]/', $input) != 1;
        }elseif($type == "color"){
            return preg_match('/^#[A-Fa-f0-9]{6}$/', $input) === 1;
        }
        
    }
}

if(!sanitizeNickname($nickname,"name") || strlen($nickname) > 15 || empty($nickname)){

    $nickname = "fucker";

}else{
    $nickname = trim($nickname);
}

if(!sanitizeNickname($color,"color") || isColorNearBlack($color)){

    $color = "#585858";

}else{
    $color = $color;
}

if(sanitizeNickname($adminpassword,"name")){

    $_SESSION['admin'] = password_hash($adminpassword, PASSWORD_DEFAULT);

}



// Generate a unique ID for the user
$userId = uniqid(); // Generates a unique ID based on the current time in microseconds


$_SESSION['nickname'] = $nickname;
$_SESSION['color'] = $color;
$_SESSION['id'] = $userId;

#$_SESSION['ACTIVE'] = time();

$entry = json_encode([
    "id" => $userId,
    "username" => $nickname,
    "color" => $color,
    "admin" => password_hash($adminpassword, PASSWORD_DEFAULT),
    "status" => "ok"
]) . "\n";


file_put_contents($userFile, $entry, FILE_APPEND);

header("Location: ../index.php");


?>
