<?php
    $host = "localhost"; $dbname = "reservas"; $user = "root"; $pass = "1234";

    try {
        $DBH = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        
    }
    if (isset($DBH)){  

        $RES = $DBH->query('SELECT Nome, Curso FROM reservas');

        # definir o modo como será feito o fetch
        $RES->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $RES->fetch()) { 
            echo $row['Nome'] . "<br>";
            echo $row['Curso'] . "<br>";
        }

        //também poderia ser usado o método fetchAll() 

    }
?>

