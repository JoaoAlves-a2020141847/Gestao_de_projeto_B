<?php
class gereUtilizador{

        private array $exercicio;

        public function __construct(){
            $this->exercicio=array();
        }
        public function pesquisaAdmin($login){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("SELECT * FROM admin WHERE a_username=?;");
            $STH->execute(array($login));
            
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $record = $STH->fetch();


            $user=new utilizador($record->a_username,$record->a_password);
            return $user;
        }
    }
?>