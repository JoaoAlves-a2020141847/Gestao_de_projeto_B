<?php

    Class gereReserva{

        private array $reserva;

        public function __construct(){

        }

        public function contaDias(){

            $str=file_get_contents('bilhetes');
            $str=explode(PHP_EOL,$str);
            $resultado=array();
            for($i=0;$i<count($str);$i++){

                $strEX=explode(";",$str[$i]);
                $strEX2=explode(",",$strEX[3]);
                
                foreach($strEX2 as $aux){
                    if(array_key_exists($aux,$resultado)){
                        $resultado[$aux]+=1;
                    }
                    else{
                        $resultado[$aux]=1;
                    }
                }
            }
            $str='';
            $str.="Dia 1: ".$resultado["Dia 1"]."<br>" ?? 0;
            $str.="Dia 2: ".$resultado["Dia 2"]."<br>" ?? 0;
            $str.="Dia 3: ".$resultado["Dia 3"]."<br>" ?? 0;
            $str.="Dia 4: ".$resultado["Dia 4"]."<br>" ?? 0;
            $str.="Dia 5: ".$resultado["Dia 5"]."<br>" ?? 0;
            return $str;
        }
        
        public function listarReservas(){
            $dias=array();
            
            $str=file_get_contents('bilhetes');
            $str=explode(PHP_EOL,$str);
            $resultado=array();
            for($i=0;$i<count($str);$i++){

                $strEX=explode(";",$str[$i]);
                $strEX2=explode(",",$strEX[3]);
                $nome=$strEX[0];
                $curso=$strEX[1];
                $tipo=$strEX[2];
                for($j=0;$j < count($strEX2);$j++){
                    $dias[$j]=$strEX2[$j];
                }
                $contacto=$strEX[4];
                $this->reserva[$i] = new Reserva($nome,$curso,$tipo,$dias,$contacto);
            }
            return $this->reserva;
        }

    }

?>