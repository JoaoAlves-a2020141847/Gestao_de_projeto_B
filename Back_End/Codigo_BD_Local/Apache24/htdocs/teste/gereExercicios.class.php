<?php

    class gereExercicio{

        private array $exercicio;

        public function __construct(){
            $this->exercicio=array();
        }

        public function contaExercicios(){
            $DBH=bd::get_instance();
            $STH=$DBH->query('SELECT * FROM exercise;');
            $STH->setFetchMode(PDO::FETCH_OBJ);
            
            $records = $STH->fetchAll();
            return count($records);
        }

        public function listaExercicios(){
            $DBH=bd::get_instance();
            $STH=$DBH->query('SELECT * FROM exercise;');
            $STH->setFetchMode(PDO::FETCH_OBJ);
            
            $records = $STH->fetchAll();

            foreach($records as $record){
                $exe=new exercicio($record->e_name,$record->e_desc,$record->e_photo,
                                $record->e_muscles,$record->e_repetitions,$record->e_active,$record->e_id);
                array_push($this->exercicio,$exe);
            }
            return $this->exercicio;
        }

        public function pesquisaExercicios($eId){

            $DBH=bd::get_instance();
            $STH=$DBH->prepare('SELECT * FROM exercise
                            WHERE e_id=?;');
            $STH->execute(array($eId));
            $STH->setFetchMode(PDO::FETCH_OBJ);
            
            $record = $STH->fetch();


            $exe=new exercicio($record->e_name,$record->e_desc,$record->e_photo,
                                $record->e_muscles,$record->e_repetitions,$record->e_active,$record->e_id);
            return $exe;

        }
    }

?>