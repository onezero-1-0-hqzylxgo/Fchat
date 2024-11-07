<?php
$adminKey = "fuck";


session_start();


if(!isset($_SESSION['nickname']) || !$_SESSION['color']){
    header("Location: login.php");
}




$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch($action){

    case 'kicked':
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">            <link rel="stylesheet" href="static/style.css">
        </head>
        <body> 
        <div class="kicked">
            <h3>You Was Kicked by admin staff dont spam/cp or eany other illigel activity logout and login again to acess chat</h3>
        </div>
        </body>
        </html>
        <?php
        break;
        
    case 'userslist':
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="refresh" content="7">
            <link rel="stylesheet" href="static/style.css">
        </head>
        <body style="margin: 0;padding: 0;"> 
        <div class="usersside" id="userslist">
            <!-- <div style="margin-bottom: 1rem;margin-left: 3%;color: white;font-size:1.5rem;">
            Admins
            </div> -->
        

            <?php
            function getUsers() {
                $url = 'http://127.0.0.1/proccess/usersget.php';
                $users = file_get_contents($url);
                return json_decode($users, true);
            }   

            $admins = [];
            $users = getUsers();

            echo '<div class="members">';
            echo '<h2 style="margin: 0 0.1rem 0 0.5rem;color: rgb(170, 170, 170);">members - '. count($users) - 1 .'</h2>';
            foreach ($users as $userArray) {
                $user = json_decode($userArray, true);
                  
                if (isset($user['username']) && !empty($user['username'])) {
                    
                    
                    if(password_verify($adminKey, $user['admin'])){
                        
                        $admins[] = $user;
                                
                    }else{
                        echo "<div class='user'>";
                        echo '<div class="user_pic" style="background-color: '. $user['color'] .';"></div><div class="username">'. $user['username'] .'</div></br>';
                        if(password_verify($adminKey, $_SESSION['admin'])){
                            echo '<button class="kickbutton"><a href="logout.php?user='. $user['id'] .'">kick</a></button>';
                        }
                        echo "</div>";
                    }

                }
                
                            
            }
            echo '</div>';

            echo '<div class="admins" style="order: -1;">';
            echo '<h2 style="margin: 0 0.1rem 0 0.5rem;color: rgb(170, 170, 170);">Admins</h2>';
            foreach($admins as $user){
                echo "<div class='user'>";
                echo '<div class="user_pic" style="background-color: '. $user['color'] .';"></div><div class="username" style="color: '. $user['color'] .';text-shadow: 0 0 5px '. $user['color'] .',0 0 10px '. $user['color'] .', 0 0 15px '. $user['color'] .', 0 0 100px '. $user['color'] .';">'. $user['username'] .' 👑</div></br>';
                echo '</div>';
            }
            echo '</div>';         
                
            ?>

            </div>
        </body>
        <?php
        break;
    case 'chatbox':
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="static/style.css">
        </head>
        <body style="margin: 0;padding: 0;"> 
        <div class="chatbox">

            <form action="proccess/chatsend.php" method="POST" class="chat-form">

                <div class="form_item_box">
                    <input type="text" name="message" id="usermessage" placeholder="Enter Message" required>
                </div>


                <div class="form_item_send">
                    <input type="submit" value="➤">
                </div>

            </form>

        </div>
        </body>
        <?php
        break;
    case 'chat':
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="refresh" content="3">
            <link rel="stylesheet" href="static/style.css">
        </head>
        <body style="margin: 0;padding: 0;overflow: hidden;"> 
        <div class="chats" id="chatstbody">
                    <?php

                    function getChatMessages() {
                        $url = 'http://127.0.0.1/proccess/chatget.php';
                        $messages = file_get_contents($url);
                        return json_decode($messages, true);
                    }
                    
                    $messages = getChatMessages();
                    
                        
                        echo "<div class='msg'>";
                        foreach ($messages as $msgArray) {
                            $msg = json_decode($msgArray, true);

                            if ((isset($msg['auther']) && !empty($msg['auther'])) && (isset($msg['message']) && !empty($msg['message'])) && (isset($msg['color']) && !empty($msg['color']))) {
                                echo '<div class="auther" style="color: '. $msg['color'] .';text-shadow: 0 0 5px '. $msg['color'] .',0 0 10px '. $msg['color'] .', 0 0 15px '. $msg['color'] .', 0 0 100px '. $msg['color'] .';">'. $msg['auther'] .'</div><div class="content" style="color: '. $msg['color'] .';text-shadow: 0 0 5px '. $msg['color'] .',0 0 10px '. $msg['color'] .', 0 0 15px '. $msg['color'] .', 0 0 100px '. $msg['color'] .';">'. $msg['message'] .'</div>';
                                
                            }else{
                                
                            }
                        }
                        echo "</div>";
                    

                    
                    ?>
                    
                </div>
        <?php
        break;

    default:
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Fchat-start</title>
            <link rel="stylesheet" href="static/style.css">
        </head>
        <body>
        <?php
        
        

        ?>
        <div class="container-chat">

            <div class="yourside-out">

                <div class="yourside">

                    <?php echo '<div class="you" style="background-color: ' . $_SESSION['color'] . ';">' ?>
                    </div>
                    <?php echo '<div class="yourname" style="color: '. $_SESSION['color'] .';text-shadow: 0 0 5px '. $_SESSION['color'] .',0 0 10px '. $_SESSION['color'] .', 0 0 15px '. $_SESSION['color'] .', 0 0 100px '. $_SESSION['color'] .';">'. $_SESSION['nickname'] .'</div>'; 
                    ?>
                    
                </div>
                <?php
                if(isset($_SESSION['admin']) && password_verify($adminKey,$_SESSION['admin'])){
                    echo '<div class="admin">you have admin acess</div>';
                }
                ?>
                <div class="imojis">
                    <div class="smile"><span class="imoji">😀</span> <span class="imoji">😁</span> <span class="imoji">😂</span> <span class="imoji">😊</span> <span class="imoji">🤔</span> <span class="imoji">😐</span> <span class="imoji">😑</span> <span class="imoji">🙄</span> <span class="imoji">😶</span> <span class="imoji">😏</span> </div>
                    <div class="hand"><span class="imoji">👋</span> <span class="imoji">🤚</span> <span class="imoji">✋</span> <span class="imoji">👌</span> <span class="imoji">🤏</span> <span class="imoji">✊</span> <span class="imoji">✋</span> <span class="imoji">🤞</span> <span class="imoji">👏</span> <span class="imoji">👍</span></div>
                    <div class="hacking"><span class="imoji">🧑‍💻</span> <span class="imoji">🕵️‍♂️</span> <span class="imoji">💣</span> <span class="imoji">🔑</span> <span class="imoji">🔒</span> <span class="imoji">💾</span> <span class="imoji">🛠️</span> <span class="imoji">🕶️</span> <span class="imoji">🛰️</span> <span class="imoji">⚙️</span></div>
                </div>
                <div class="logout"><a href="logout.php">LogOut</a></div>

            </div>

            <div class="chatside">

                <iframe src="index.php?action=chat" frameborder="0" style="height: 84vh;"></iframe>

                <hr style="width: 100%;height: 0px;">

                <iframe src="index.php?action=chatbox" frameborder="0" style="height: 10vh;"></iframe>
                
            </div>

            <iframe src="index.php?action=userslist" frameborder="0" style="height: 100vh;width: 20vw;"></iframe>

            
        </div>
                    
        </body>
        </html>


        <?php
        break;

}




?>



    
    
