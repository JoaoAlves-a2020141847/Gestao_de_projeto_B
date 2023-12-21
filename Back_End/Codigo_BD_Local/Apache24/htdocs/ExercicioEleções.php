<?php
    $votos="Zé Zé Vasco Vasco Vasco Vasco Vasco Vasco Samuel Vasco Tomas Tomas Samuel Zé Rodas Bruno Vasco Tomas";
    $votosSep=explode(" ",$votos);
    $counter=0;
    $resultado=array();
    foreach($votosSep as $aux){
        if(array_key_exists($aux,$resultado)){
            $resultado[$aux]+=1;
        }
        else{
            $resultado[$aux]=1;
        }
    }

    $max;
    $maxA=0;
    $vencedor;
    foreach($resultado as $key=>$val){
        $max=$val;
        
        if($max>$maxA){
            $maxA=$max;
            $vencedor=$key;
        }
    }
    echo $vencedor;
    
?>
