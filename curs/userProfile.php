<?php
    include("classes/connectClasses.php");

    session_start();
    
    $query = "SELECT * FROM users WHERE userid = :userid";

    $params = ['userid' => $_SESSION['site_userid']];
    $db = new ConnectDataBase();
    $result = $db->readPrepared($query, $params);
    if(!isset($_SESSION['site_userid'])){
        header("Location: login.php");
        die;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/profile.css">
    
    <title>USER NAME | <?php echo $result[0]['first_name']." ".$result[0]['last_name'];?></title>
    <style>
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .center-link {
            margin: 0 auto;
        }
        .userInfo{
            height: 500px;
            background-color: aliceblue;
            width: 1200px;
            margin: auto;
            margin-top: 200px;
            font-size: 40px;
        }
    </style>
</head>
<body>
    <div class="top">
        <a href="userProfile.php"><?php echo $result[0]['first_name']." ".$result[0]['last_name'];?></a>
        <a class="center-link" href="profile.php">search people</a>
        <a href="logout.php">LOGOUT</a>
    </div>
    <div class="userInfo">
        INFO <?php echo $result[0]['first_name']." ".$result[0]['last_name'];?>
        <ul>
            <li>FULL USER NAME: <?php echo $result[0]['first_name']." ".$result[0]['last_name'];?></li>
            <li>USER-ID: <?php echo $result[0]['url_address'];?></li>
            <li>USER AGE: <?php echo $result[0]['age'];?></li>
            <li>USER GENDER: <?php echo $result[0]['gender'];?></li>
            <li>USER EMAIL: <?php echo $result[0]['email'];?></li>
            <li>REGISTRATION DATE: <?php echo $result[0]['date'];?></li>
            <p style="color:royalblue; font-weight: 600;">The user's ID is required to enter the chat for communication.</p> 
        </ul>
    </div>
</body>
</html>
