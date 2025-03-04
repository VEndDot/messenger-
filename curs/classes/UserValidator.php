<?php
    /**
     * 
     * Проверяет существует ли пользователь в бд
     */
    class UserValidator{

        // Проверяет есть ли майл в базе
        public function isEmailUnique($email){
            $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
            $param = [':email'=>$email];

            $db = new ConnectDataBase();
            $result = $db->readPrepared($query, $param);
            return $result[0]['count'];  
        }
    }
?>