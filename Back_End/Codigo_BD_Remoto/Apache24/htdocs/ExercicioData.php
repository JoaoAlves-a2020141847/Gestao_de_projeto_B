<?php

    $data = '31/03/2023';
    $data = explode("/",$data);
    
    $meses=array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
    echo "Hoje dia ",$data[0]," de ",$meses[(int)$data[1]]," de ",$data[2];

    foreach($meses as $key=>$val){
        echo "<br>",$key,":",$val;

    }

    //Complicado
    
    // switch($data[1]){
    //     case 1: $data[1]="Janeiro"; break;
    //     case 2: $data[1]="Fevereiro";break;
    //     case 3: $data[1]="Março";break;
    //     case 4: $data[1]="Abril";break;
    //     case 5: $data[1]="Maio";break;
    //     case 6: $data[1]="Junho";break;
    //     case 7: $data[1]="Julho";break;
    //     case 8: $data[1]="Agosto";break;
    //     case 9: $data[1]="Setembro";break;
    //     case 10: $data[1]="Outubro";break;
    //     case 11: $data[1]="Novembro";break;
    //     case 12: $data[1]="Dezembro";break;
    // }



?>