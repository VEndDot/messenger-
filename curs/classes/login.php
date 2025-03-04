<?php 
    class Login{
        
        public function authUser($email, $password){
            $valid = new UserValidator();
            
            if ($valid->isEmailUnique($email) == 1){
                $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $params = [':email' => $email];
                $db = new ConnectDataBase();
                $result = $db->readPrepared($query,$params); 
                $hash = $result[0]['password'];

                if(password_verify($password, $hash)){
                    $_SESSION['site_userid'] = $result[0]['userid'];
                }else{
                    return throw new Exception("Неверный майл или пароль");
                }
            }else{
                return throw new Exception("Неверный майл или пароль");
            }
        }

    }
?>