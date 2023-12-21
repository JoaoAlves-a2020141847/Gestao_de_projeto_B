<?php 
    $str='';
    $desconto=1;
    if(isset($_POST["name"])){
        if(!empty($_POST["name"])){
            $str.=$_POST["name"].";";
        }   
    }
    if(isset($_POST["curso"])){
        $str.=$_POST["curso"].";";
    }
    if(isset($_POST["estudante"])){
        $str.=$_POST["estudante"].";";
        if($_POST["estudante"]=='estudante'){
            $desconto=0.5;
        }
    }
    if(isset($_POST["dia"])){
        for($i=0;$i < count($_POST["dia"]);$i++){
            if($i==count($_POST["dia"])-1){
                $str.=$_POST["dia"][$i].";";
            }
            else{
                $str.=$_POST["dia"][$i].",";
            }
            
            $preco=5*count($_POST["dia"]);
        }
    }
    $preco=$preco*$desconto;
    if(isset($_POST["telefone"])){
        $str.=$_POST["telefone"].";";
    }
    $str.=$preco.PHP_EOL;

    file_put_contents('bilhetes',$str,FILE_APPEND);
    
?>