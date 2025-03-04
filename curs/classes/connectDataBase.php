<?php
    class ConnectDataBase{
        private $host = 'localhost';
        private $dbname = 'site_bd';
        private $username = 'root';
        private $password = '';
        private $pdo;

        // приватная функция подключения к БД
        private function connect(){
            try {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password);
                
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }

        // функция чтения данных из БД
        public function readPrepared($query, $params = []){
            if(!$this->pdo){
                $this->connect();
            }

            try{
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }catch(PDOException $e){
                throw new Exception("Ошибка чтения из БД: " . $e->getMessage());
            }
        }

        // функция сохранения\изменения\удаления данных в бд
        public function savePrepared($query, $params = []){
            if(!$this->pdo){
                $this->connect();
            }
            try{
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                return true;
            }catch(PDOException $e){
                throw new Exception("Ошибка изменения данных в БД: " . $e->getMessage());
            }
        }
    }
?>