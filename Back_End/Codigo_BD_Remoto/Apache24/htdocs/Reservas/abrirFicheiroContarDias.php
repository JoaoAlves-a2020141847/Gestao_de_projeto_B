<?php
function processaFile(){
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
    echo "Dia 1: ".$resultado["Dia 1"]."<br>" ?? 0;
    echo "Dia 2: ".$resultado["Dia 2"]."<br>" ?? 0;
    echo "Dia 3: ".$resultado["Dia 3"]."<br>" ?? 0;
    echo "Dia 4: ".$resultado["Dia 4"]."<br>" ?? 0;
    echo "Dia 5: ".$resultado["Dia 5"]."<br>" ?? 0;
}

processaFile();

?>