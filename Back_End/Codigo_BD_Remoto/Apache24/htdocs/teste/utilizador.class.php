<?php

    class utilizador{

        private string $login;
        private string $pass;

        public function __construct(string $aLogin,string $aPass){

            $this->login = $aLogin;
            $this->pass = $aPass;

        }

        public function auth(){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("SELECT a_username, a_password FROM admin WHERE a_username=?;");
            $STH->execute(array($this->login));
            
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $records = $STH->fetch();

            if(!empty($records)){
                if(password_verify( $this->pass , $records->a_password)){
                    //login com sucesso
                    return true;
                }
                else{
                    //login sem sucesso
                    return false;
                }
            }
            else{
                //parametros vazios
                return false;
            } 
        }
        public function verificaPassOld($oldPass){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("SELECT a_password FROM admin WHERE a_username=?;");
            $STH->execute(array($this->login));
            
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $records = $STH->fetch();

            if(!empty($records)){
                if(password_verify( $oldPass , $records->a_password)){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
        public function alterarPass($newPass){
            $enc_pass = password_hash($newPass, PASSWORD_DEFAULT);
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("UPDATE admin SET a_password = ? WHERE a_username = ?;");
            $STH->execute(array($enc_pass,$this->login));
        }
        public function setPass($aPass){
            $this->pass=$aPass;
        }

        public function getLogin(){
            return $this->login;
        }
        
    }

?>
