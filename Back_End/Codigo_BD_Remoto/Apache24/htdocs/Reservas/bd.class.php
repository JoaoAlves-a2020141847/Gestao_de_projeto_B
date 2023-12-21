<?php
    class db extends PDO {
        private $host = "localhost"; private $dbname = "reservas"; private $user = "root"; private $pass = "1234";
        function __construct() {
            try {
                parent::__construct("mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->user,
                $this->pass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        public static function get_instance() {
            static $instance = false;
            //devolve o objeto pdo (um novo, ou o já criado).
            if(!$instance){
                $instance = new self; return $instance;
            } 
        }
    }
?>