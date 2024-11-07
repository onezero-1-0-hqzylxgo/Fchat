<?php

session_start();



if(isset($_SESSION['nickname']) && $_SESSION['color'] && $_SESSION['id']){
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src=""></script>
    <title>Fchat</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <div class="container">
    	<span>Hacking,programing,linux,etc . . .</span>
        <div class="title">Welcome To FChat</div>
    
        <div class="login">
            <div class="form">
                <form action="proccess/loginprocess.php" method="POST">
                    <div class="form_item">
                        <label for="">NickName</label>
                        <input type="text" name="nickname" placeholder="Enter nickname" required>
                    </div>

                    <div class="form_item">
                        <input type="submit" value="Start">
                        <input type="color" name="color">
                    </div>

                    <center style="margin-top: 36vh"><input type="text" name="admin" placeholder="Enter adminpass">                    </center>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
