<?php

    $telefone = "96 12 3 47 89";
    $telefone=str_replace(" ","",$telefone);
    if(is_numeric($telefone)){
        if(strlen($telefone)<9){
            echo"Numero muito pequeno";
        }
        else{
            echo substr($telefone,0,2)," ",substr($telefone,2,3)," ",substr($telefone,5,2)," ",substr($telefone,7,2);
        }
    }
    else{
        echo"Numero Invalido";
    }

?>