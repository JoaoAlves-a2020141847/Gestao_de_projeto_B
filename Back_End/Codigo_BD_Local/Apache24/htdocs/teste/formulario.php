<?php
    include("i18n.php");
    session_start();
    if(isset($_SESSION['idioma'])){
        $lang=$_SESSION['idioma'];
    }
    else{
        $lang='en';
    }
    if (file_exists ("i18n_" . $lang . ".php")){
        include "i18n_" . $lang . ".php";
    }
    else{
        include "i18n_en.php";
    }
        $erro='';
        if (isset($_GET['erro'])) {
            $erro='<div class="alert alert-danger" role="alert">
                        ' . i18n(MSG_ERROR_LOGIN) . '
                    </div>';
        }
        $strForm='<!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
                <title>GymLog</title>
            </head>
            <style>
                .container{
                    border-color: #32383e;
                    padding-top: 5rem;
                    padding-bottom: 5rem;
                    margin-top: 1rem;
                    border-radius: 0.375rem;
                }
                .formFooter {
                    background-color: #f6f6f6;
                    border-top: 1px solid #dce8f1;
                    padding: 25px;
                    border-radius: 0 0 10px 10px;
                }
                .wrapper {
                    align-items: center;
                    flex-direction: column; 
                    justify-content: center;
                    border-top: var(--bs-border-width) solid var(--bs-border-color);
                    width: 50%;
                    margin-left: auto;
                    margin-right: auto;
                    min-height: 100%;
                    padding-top: 20px;
                }
                .img-thumbnailM {
                    padding: 0.25rem;
                    background-color: var(--bs-body-bg);
                    border: var(--bs-border-width) solid var(--bs-border-color);
                    border-radius: 10rem;
                    max-width: 100%;
                    height: auto;
                }
                .form-label {
                    margin-top: 0.5rem;
                }
                .alert-danger{
                    margin-left: 10px;
                    margin-right: 10px;
                }

            </style>

            <body>
                <h1>GYMLOG</h1>
                <div class="text-center">
                    <div class="wrapper text-center border rounded shadow mb-5">
                        
                        <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="img-thumbnailM" width="200" height="200">

                        <form method="POST" action="main.php" class="text-center">
                            
                            <div class="form-outline mb-4">
                                <input name="login" class="form-label" type="text" placeholder="Login" required><br>
                            </div>
                            <div class="form-outline mb-4">
                                <input name="pass" class="form-label" type="password" placeholder="Password" required><br>
                            </div>
                                <input type="submit" class="btn btn-primary btn-block mb-4" name="button" value="'.i18n(LOGIN_BUTTON).'">
                        </form>
                        '.$erro.'
                        <form method="POST" action="atualizaLingua.php" class="text-center formFooter">
                            <p>'.i18n(LANGUAGE_LABEL).'</p>
                            <button type="submit" name="idioma" class="btn btn-secondary" value="pt">PT</button>
                            <button type="submit" name="idioma" class="btn btn-secondary" value="en">EN</button>
                            <button type="submit" name="idioma" class="btn btn-secondary" value="es">ES</button>
                        </form>
                    </div>
                </div>
            </body>

            </html>';
    
    echo $strForm;

    if(isset($_POST["logout"])){
        unset($_SESSION["login"]);
    }
    else if(isset($_SESSION["login"])){
        header("Location: main.php");
        exit();
    }
?>