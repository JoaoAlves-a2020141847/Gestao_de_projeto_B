<?php
    include("bd.class.php");
    include("reserva.class.php");
    include("gereReserva.class.php");

    // $desconto=1;
    // $dias = array();
    // if(isset($_POST["name"])){
    //     if(!empty($_POST["name"])){
    //         $name=$_POST["name"];
    //     }   
    // }
    // if(isset($_POST["curso"])){
    //     $curso=$_POST["curso"];
    // }
    // if(isset($_POST["estudante"])){
    //     $tipo=$_POST["estudante"];
    // }
    
    // if(isset($_POST["dia"])){
    //     for($i=0;$i < count($_POST["dia"]);$i++){
    //         $dias[$i]=$_POST["dia"][$i];
    //     }
    // }
    // if(isset($_POST["telefone"])){
    //     $contacto=intval($_POST["telefone"]);
    // }

    // $r1 = new Reserva($name,$curso,$tipo,$dias,$contacto);

    // $r1->guardar();
    
    $gr1 = new gereReserva();

    $arr=$gr1->listarReservas();
    for($i=0;$i<count($arr);$i++){
        print($arr[$i]."<br><br>");
    }

?>