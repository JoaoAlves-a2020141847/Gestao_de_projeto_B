<?php

    Class gereReserva{

        private array $reserva;

        public function __construct(){

        }

        public function contaDias(){
            $DBH=bd::get_instance();
            $STH=$DBH->query('SELECT D_Dia AS "Dia", COUNT(*) AS "Numero"
                            FROM reservadias AS r, dias AS d 
                            WHERE r.D_ID=d.D_ID
                            GROUP BY d.D_ID');
            $STH->setFetchMode(PDO::FETCH_OBJ);
            
            $records = $STH->fetchAll();
            $str="";
            foreach($records as $r){
                $str.=$r->Dia . "-";
                $str.=$r->Numero . "<br>";
            }

            return $str;
        }
        
        public function listarReservas(){

            $DBH=bd::get_instance();
            $STH=$DBH->query('SELECT * FROM reservas');
            $STH->setFetchMode(PDO::FETCH_OBJ);
            
            $records = $STH->fetchAll();
            $str="";
            foreach($records as $r){
                $str.=$r->R_Nome . " ";
                $str.=$r->R_Curso . " ";
                $str.=$r->R_Tipo . " ";
                $str.=$r->R_Contacto . " ";

                $STH=$DBH->query('SELECT D_Dia FROM reservadias rd,dias d WHERE rd.D_ID=d.D_ID AND rd.R_ID='.$r->R_ID.';');
                $STH->setFetchMode(PDO::FETCH_ASSOC);
                
                $dias = $STH->fetchAll();
                $diasR=array();
                foreach($dias as $dia){
                    $diasR[]=$dia["D_Dia"];
                }
                $str.=implode(", ",$diasR);
                $str.="<br>";
            }
            return $str;
        }

    }

?>