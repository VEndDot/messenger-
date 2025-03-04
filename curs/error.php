<?php 
    /*
        выводит пользователю ошибки
        при неправильной регистрации
    */ 
    echo "<div class='error-block'>";
    echo "<h3>Ошибка регистрации</h3>";
    echo "<p>{$e->getMessage()}</p>";
    echo "</div>";
?>