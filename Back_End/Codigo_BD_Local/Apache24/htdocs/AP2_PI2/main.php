
<?php
    include("i18n.php");
    include("bd.class.php");
    include("utilizador.class.php");
    include("exercicio.class.php");
    include("gereExercicios.class.php");

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
        include "i18n_pt.php";
    }
    $strerr='
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
            <title>GymLog</title>
        </head>
        <style>
            .MYthead-dark{
                color: #fff;
                background-color: #212529;
                border-color: #32383e;
            }
            .col-1 {
                width: 4.4%;
            }
            .dark{
                background-color: #212529 !important;
                color: white;
            }
            .table{
                width: 50%;
                margin-left: auto;
                margin-right: auto;
            }
            .afastaEs{
                margin-left: 2rem;
            }
        </style>';
    $strBoot='
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            <title>GymLog</title>
            <style>
                html{
                    overflow-x: hidden;
                }
                .MYthead-dark{
                    color: #fff;
                    background-color: #212529;
                    border-color: #32383e;
                }
                .img-thumbnailM {
                    padding: 0.25rem;
                    background-color: var(--bs-body-bg);
                    border: var(--bs-border-width) solid var(--bs-border-color);
                    border-radius: 10rem;
                    max-width: 100%;
                    height: auto;
                }
                .inline{
                    display: inline-block;
                }
                .col-1 {
                    width: 4.4%;
                }
                .col-2 {
                    width: 10.5%;
                }
                .col-10 {
                    width: 84%;
                }
                .paRight{
                    padding-right: 1rem;
                }
                .paTop{
                    padding-top: 0.5rem;
                }
                .wrapper{
                    border-bottom: var(--bs-border-width) solid var(--bs-border-color);
                }
            </style>
        
            </head>
        <div class="row justify-content paTop wrapper">
            <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="col-1"" width="55" height="55">
            <h1 class="col-10">GYMLOG</h1>
            <form method="POST" class="col-2" action="formulario.php">
                <input type="submit" class="btn btn-danger" name="logout" value="'.i18n(LOGOUT_BUTTON).'">
            </form>
        </div>
        <div class="d-flex justify-content-end">
            <form method="POST" class="paRight text-center" action="atualizaLingua.php">
                <p>'.i18n(LANGUAGE_LABEL).'</p>
                <button type="submit" class="btn btn-secondary" name="idioma" value="pt">PT</button>
                <button type="submit" class="btn btn-secondary" name="idioma" value="en">EN</button>
                <button type="submit" class="btn btn-secondary" name="idioma" value="es">ES</button>
            </form>
        </div>';
    $str=$strBoot.'<form method="POST" action="main.php" class="text-center">
            <div class="form-outline mb-4">
                <input name="login" class="form-label" type="text" placeholder="Login" required><br>
            </div>
            <div class="form-outline mb-4">
                <input name="pass" class="form-label" type="password" placeholder="Password" required><br>
            </div>
                <input type="submit" class="btn btn-primary btn-block mb-4" name="button" value="'.i18n(LOGIN_BUTTON).'">
            
            </form>';

    if(isset($_SESSION["login"])){
        $login=$_SESSION["login"];
    }
    else{
        if(isset($_POST["login"])){
            if(!empty($_POST["login"])){
                $login=$_POST["login"];
            }   
        }
        if(isset($_POST["pass"])){
            if(!empty($_POST["pass"])){
                $pass=$_POST["pass"];
            }   
        }
        if(!(empty($pass)&&empty($login))){
            $admin = new utilizador($login,$pass);
            $veri=$admin->auth();
            if($veri){
                $_SESSION["login"]= $login;
            }
            else{
                header("Location: formulario.php?erro=" . urlencode(1));
                exit();
                //echo $str."<br><h1>".i18n(MSG_ERROR_LOGIN)."</h1>";
            }
        }
    }
    if(isset($_SESSION["login"])){
        $gereExe = new gereExercicio();
        $listaExe='';
        if($gereExe->contaExercicios()==0){
            $listaExe=$strBoot.'
            <div class="text-center">
                <h3>'.i18n(MSG_NO_EXERCISE).'</h3>
            </div>';
        }
        else{
            $exercicios=$gereExe->listaExercicios();
            $listaExe=$strBoot.'<form method="POST" action="formularioExercicios.php">
                                    <table class="table table-striped">
                                        <thead class="MYthead-dark">
                                            <tr>
                                                <th scope="col">'.i18n(LABEL_TABLE_EXE_NAME).'</th>
                                                <th scope="col">'.i18n(LABEL_TABLE_EXE_ACTIONS).'</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
            $estado='';
            foreach($exercicios as $e){
                if($e->getActive()){
                    $estado=i18n(DEACTIVATE);
                }
                else{
                    $estado=i18n(ACTIVATE);
                }
                
                $listaExe.='
                <tr>
                    <td>'.$e->getNome().'</td>
                    <td>
                        <input type="submit" name="details['.$e->getId().']" value="'.i18n(DETAILS).'">
                        <input type="submit" name="edit['.$e->getId().']" value="'.i18n(EDIT).'">
                        <input type="submit" name="deactivate['.$e->getId().']" value="'.$estado.'"><br>
                    </td>
                </tr>';
            }
            $listaExe.='
                                </tbody>
                            </table>
                        </form>';
        }
        $succEdit='';
        $succAdd='';
        if(isset($_GET["successEditExe"]) && $_GET["successEditExe"] == "true") {
            $succEdit='
                    <div class="toast show bg-success" style="position: absolute; top: 630; right: 20;">
                        <div class="toast-header bg-success">
                            <strong class="me-auto text-light">'.i18n(TOAST_EDIT_EXE_H).'</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p class="text-light">'.i18n(TOAST_EDIT_EXE_MSG).'</p>
                        </div>
                        </div>
                    </div>
            ';
        }
        if(isset($_GET["successAddExe"]) && $_GET["successAddExe"] == "true") {
            $succAdd='
                    <div class="toast show bg-success" style="position: absolute; top: 630; right: 20;">
                        <div class="toast-header bg-success">
                            <strong class="me-auto text-light">'.i18n(TOAST_ADD_EXE_H).'</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p class="text-light">'.i18n(TOAST_ADD_EXE_MSG).'</p>
                        </div>
                        </div>
                    </div>
            ';
        }
        if(isset($_GET["successChPass"]) && $_GET["successChPass"] == 1){
            $succAdd='
                    <div class="toast show bg-success" style="position: absolute; top: 630; right: 20;">
                        <div class="toast-header bg-success">
                            <strong class="me-auto text-light">'.i18n(TOAST_CH_PASS_H).'</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p class="text-light">'.i18n(TOAST_SUC_CH_PASS_MSG).'</p>
                        </div>
                        </div>
                    </div>
            ';
        }
        else if(isset($_GET["successChPass"]) && $_GET["successChPass"] == 2){
            $succAdd='
                    <div class="toast show bg-danger" style="position: absolute; top: 630; right: 20;">
                        <div class="toast-header bg-danger">
                            <strong class="me-auto text-light">'.i18n(TOAST_CH_PASS_H).'</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p class="text-light">'.i18n(TOAST_ERROR1_CH_PASS_MSG).'</p>
                        </div>
                        </div>
                    </div>
            ';
        }
        else if(isset($_GET["successChPass"]) && $_GET["successChPass"] == 3){
            $succAdd='
                    <div class="toast show bg-danger" style="position: absolute; top: 630; right: 20;">
                        <div class="toast-header bg-danger">
                            <strong class="me-auto text-light">'.i18n(TOAST_CH_PASS_H).'</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p class="text-light">'.i18n(TOAST_ERROR2_CH_PASS_MSG).'</p>
                        </div>
                        </div>
                    </div>
            ';
        }
        echo $listaExe.'
        <div class="text-center">
            <form method="POST" action="formularioExercicios.php">
                <input type="submit" class="btn btn-primary" name="addExercicise" value="'.i18n(ADD_EXERCISE_BUTTON).'">
                <input type="submit" class="btn btn-secondary" name="chPass['.$_SESSION["login"].']" value="'.i18n(CH_PASSWORD_BUTTON).'">
            </form>
        </div>
        '.$succEdit.$succAdd;
        
    
    }
    else{
        echo $strerr.'
        <form method="POST" class="text-center" action="formulario.php">
            <h3>'.i18n(MSG_ERROR_SESSION).'</h3>
            <input type="submit" class="btn btn-secondary" name="backLogin" value="'.i18n(ERROR_SESSION_BACK_BUTTON).'">
        </form>';
    }
?>