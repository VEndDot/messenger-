<?php
    include("classes/connectClasses.php");
    session_start();
    $email = '';
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_POST['email'];

        try{
            $login = new Login();
            
            $login->authUser($email, $_POST['password']);
            header('Location: profile.php');
            die;
        }catch(Exception $e){
            // вывод ошибок
            include("error.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/regLog.css">

    <title>Login</title>
    
</head>
<body>
    <div class="welcome">Welcome to the login page</div>
    <div class="regist_form">
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Enter your email: " value="<?php echo htmlspecialchars($email);?>">
            
            <input type="password" name="password" placeholder="Enter password: ">
            <br><br><br>
            <!-- Отправить форму -->
            <input class="button" type="submit" value="Login">    
            <br><br><br><br>
            <a href="register.php">don't have an account yet? then go to the registration page</a>
        </form>
    </div>
</body>
</html>
