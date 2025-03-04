<?php
    include("classes/connectClasses.php");

    // подключаем файл конфигурации
    
    $first_name = '';
    $last_name = '';
    $email = '';
    $age = '';


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        try{

            $valid = new FormDataValidator();
            $valid ->checkFormData($_POST);
            
            $user = new User();
            $user->createUser($_POST);

            // сообщаем об успешной регистрации
            include("success.php");

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
    <title>REGISTER</title>
</head>
<body>
    <div class="welcome">Welcome to the registration page</div>
    <div class="regist_form">
        <form action="" method="POST">
            <input type="text" name="first_name" placeholder="Enter your first name: " value="<?php echo htmlspecialchars($first_name);?>">
            <input type="text" name="last_name" placeholder="Enter your last name: " value="<?php echo htmlspecialchars($last_name);?>"><br>
            <input type="password" name="password" placeholder="Enter password: ">
            <input type="password" name="password2" placeholder="Repeat the password: "><br>
            <input type="email" name="email" placeholder="Enter your email: " value="<?php echo htmlspecialchars($email);?>">

            <input type="number" name="age" placeholder="Enter your age: " value="<?php echo htmlspecialchars($age);?>"><br>

            <!-- Выбор пола -->
            <label for="gender">Gender:</label>
            <select name="gender" id="">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select><br><br>

            <!-- Отправить форму -->
            <input class="button" type="submit" value="Register">    
            <br><br>
            <a href="login.php">do you already have an account? then go to the login page</a>

        </form>
    </div>
</body>
</html>
