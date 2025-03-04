<?php
    // сообщение об успешной регистрации
    echo "<div class='success-block'>";
    echo "<h3>Регистрация прошла успешно!</h3>"; 
    echo "</div>";

    // подключаем js и перенаправляем пользователя на страницу входа
    echo '<script src="goingLogin.js"></script>';
    echo '<script>redirect();</script>';
?>