<?php
    session_start();
    if(isset($_POST['idioma'])) {
        $lang = $_POST['idioma'];
        $_SESSION['idioma'] = $lang;
    }
    header("Location: ".$_SERVER['HTTP_REFERER']); // Redireciona de volta à página anterior
?>