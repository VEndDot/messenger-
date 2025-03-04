<?php 
    /**
     * Создает пользователя
     * после отправки формы регистрации
     */
    class User{
        private $validator; 
        /**
         * Summary of __construct
         */
        public function __construct(){
            
            // валидатор нужен, чтобы проверить почту в БД
            $this->validator = new UserValidator();
        }

        /**
         * Регестрирует пользователя в БД
         * Если есть ошибки, то выбрасывает исключение
         * @param mixed $data Данные пользователя ввиде массива
         */
        public function createUser($data){
            // хэшируем пароль
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            // проверка на существование майла
            $resultValidEmail = $this->validator->isEmailUnique($data['email']);
            $email = $resultValidEmail == 0 ? $data['email'] : throw new Exception("Такой адрес почты уже существует");
            // создаем польз айди
            $user_id = rand(4000, 999999999999999999);
            // создаем польз уникальный адрес
            $url_address = strtolower($data['first_name']).".".strtolower($data['last_name']);
            $query = "INSERT INTO users (first_name, last_name, email, password, age, gender, userid, url_address)
                      VALUES (:first_name, :last_name, :email, :password, :age, :gender, :userid, :url_address)";
            $params = [
                ':first_name' => $data['first_name'],
                ':last_name'  => $data['last_name'],
                ':email'      => $email,
                ':age'        => $data['age'],
                ':gender'     => $data['gender'],
                ':password'   => $password,
                ':userid'     => $user_id,
                ':url_address'=> $url_address,
            ];
            $db = new ConnectDataBase();
            $db->savePrepared($query, $params);
        }
    }
?>