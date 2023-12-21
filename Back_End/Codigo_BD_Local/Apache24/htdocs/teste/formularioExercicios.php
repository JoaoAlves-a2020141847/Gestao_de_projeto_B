<?php
    include("i18n.php");
    include("bd.class.php");
    include("exercicio.class.php");
    include("utilizador.class.php");
    include("gereExercicios.class.php");
    include("gereUtilizador.class.php");

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
    $error;
    $strBoot='
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

    $strAddExe=$strBoot.'
            <div class="row justify-content paTop wrapper">
                <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="col-1"" width="55" height="55">
                <h1 class="col-10">GYMLOG</h1>
            </div>
            <div class="container border rounded shadow p-3 mb-5">
                <h3>'.i18n(H_ADD_EXE).'</h3>
                <form method="POST" class="text-center" enctype="multipart/form-data">
                    <table class="table">
                        <tbody>
                            <tr scope="row">
                                <th><label for="nameExercise">'.i18n(LABEL_TABLE_EXE_NAME).':</label></th>
                                <td><input id="nameExercise" name="nameExercise" type="text" placeholder="'.i18n(EDITADD_NAME_EXE).'" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="descExercise">'.i18n(LABEL_TABLE_EXE_DESC).':</label></th>
                                <td><input id="descExercise" name="descExercise" type="text" placeholder="'.i18n(EDITADD_DESC_EXE).'" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="photoExercise">'.i18n(LABEL_TABLE_EXE_PHOTO).':</label></th>
                                <td><input id="photoExercise" name="photoExercise" class="form-control" type="file" accept="image/png, image/jpeg" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="musclesExercise">'.i18n(LABEL_TABLE_EXE_MUSCLES).':</label></th>
                                <td><input id="musclesExercise" name="musclesExercise" type="text"placeholder="'.i18n(EDITADD_MUSCLES_EXE).'" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="repsExercise">'.i18n(EDITADD_REP_EXE).':</label></th>
                                <td><input id="repsExercise" name="repsExercise" type="number" min="0" max="200" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" class="btn btn-primary" name="exerciseAdded" value="'.i18n(ADD_EXE_BUTTON).'">
                </form>
                <form method="POST">
                    <input type="submit" class="btn btn-secondary" name="backMain" value="'.i18n(BACK_BUTTON).'">
                </form>
            </div>'; 
    

    if(isset($_SESSION["login"])){
        $_SESSION["login"];
        if(isset($_POST["addExercicise"])){
            echo $strAddExe;
        }
        else if(isset($_POST['details'])){
            $valor=array_keys($_POST['details']);
            $gereEx = new gereExercicio();
            $exe=$gereEx->pesquisaExercicios($valor[0]);
            $str='';
            if($exe->getActive()){
                $num=i18n(LABEL_STATE_ACTIVE);
            }
            else{
                $num=i18n(LABEL_STATE_DEACTIVE);
            }
           
            echo
            '
            <div class="row justify-content paTop wrapper">
                <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="col-1"" width="55" height="55">
                <h1 class="col-10">GYMLOG</h1>
            </div>
            <div class="container border rounded shadow p-3 mb-5">
                <h2>'.i18n(H_DETAILS_EXE).' '.$exe->getNome().'</h2>
                <div class="d-flex justify-content-center">
                    
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" class="dark">'.i18n(LABEL_NAME_EXE).'</th>
                                <td>'.$exe->getNome().'</td>
                            </tr>
                            <tr>
                                <th scope="row" class="dark">'.i18n(LABEL_DESC_EXE).'</th>
                                <td>'.$exe->getDesc().'</td>
                            </tr>
                            <tr>
                                <th scope="row" class="dark">'.i18n(LABEL_MUSCLES_EXE).'</th>
                                <td>'.$exe->getMuscles().'</td>
                            </tr>
                            <tr>
                                <th scope="row" class="dark">'.i18n(LABEL_REP_EXE).'</th>
                                <td>'.$exe->getReps().'</td>
                            </tr>
                            <tr>
                                <th scope="row" class="dark MYtable">'.i18n(LABEL_STATE_EXE).'</th>
                                <td>'.$num.'</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                <div class="text-center">
                    <p>'.i18n(LABEL_PHOTO_EXE).'</p>
                    <img id="foto" width=200 height=200 src="'.$exe->getPhoto().'"alt="'.i18n(LABEL_PHOTO_EXE).'">
                </div>
                
            </div>';
            
            
            
            echo $strBoot.'
                <form method="POST" action="main.php">
                    <input type="submit" class="btn btn-secondary afastaEs" name="backMain" value="'.i18n(BACK_BUTTON).'">
                </form>';
        }
        else if(isset($_POST['edit'])){
            $valor=array_keys($_POST['edit']);  
            $gereEx = new gereExercicio();
            $exe=$gereEx->pesquisaExercicios($valor[0]);
            $strEditEx = $strBoot.'
                        <div class="row justify-content paTop wrapper">
                            <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="col-1"" width="55" height="55">
                            <h1 class="col-10">GYMLOG</h1>
                        </div>
                        <div class="container border rounded shadow p-3 mb-5">
                            <h3>'.i18n(H_EDIT_EXE).' '.$exe->getNome().'</h3>
                            <form method="POST" class="text-center" enctype="multipart/form-data">
                                <table class="table">
                                    <tbody>
                                        <tr scope="row">
                                            <th><label for="repsExerciseEdit">'.i18n(LABEL_TABLE_EXE_NAME).':</label></th>
                                            <td><input id="nameExerciseEdit" name="nameExerciseEdit" type="text" value="'.$exe->getNome().'" placeholder="'.i18n(EDITADD_NAME_EXE).'" required></td>
                                        </tr>
                                        <tr scope="row">
                                            <th><label for="repsExerciseEdit">'.i18n(LABEL_TABLE_EXE_DESC).':</label></th>
                                            <td><input id="descExerciseEdit" name="descExerciseEdit" type="text" value="'.$exe->getDesc().'" placeholder="'.i18n(EDITADD_DESC_EXE).'" required></td>
                                        </tr>
                                        <tr scope="row">
                                            <th><label for="repsExerciseEdit">'.i18n(LABEL_TABLE_EXE_PHOTO).':</label></th>
                                            <td><input id="photoExerciseEdit" name="photoExerciseEdit" class="form-control" type="file" accept="image/png, image/jpeg" required></td>
                                        </tr>
                                        <tr scope="row">
                                            <th><label for="repsExerciseEdit">'.i18n(LABEL_TABLE_EXE_MUSCLES).':</label></th>
                                            <td><input id="musclesExerciseEdit" name="musclesExerciseEdit" type="text" value="'.$exe->getMuscles().'" placeholder="'.i18n(EDITADD_MUSCLES_EXE).'" required></td>
                                        </tr>
                                        <tr scope="row">
                                            <th><label for="repsExerciseEdit">'.i18n(EDITADD_REP_EXE).':</label></th>
                                            <td><input name="repsExerciseEdit" id="repsExerciseEdit" type="number" value="'.$exe->getReps().'" min="0" max="200" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="submit" class="btn btn-primary" name="exerciseEdited['.$valor[0].']" value="'.i18n(EDIT_EXE_BUTTON).'">
                            </form>
                            <form method="POST">
                                    <input type="submit" class="btn btn-secondary" name="backMain" value="'.i18n(BACK_BUTTON).'">
                            </form>
                        </div>';            
            echo $strEditEx;
        }
        else if(isset($_POST['deactivate'])){
            $valor=array_keys($_POST['deactivate']);
            $gereEx = new gereExercicio();
            $exe=$gereEx->pesquisaExercicios($valor[0]);
            
            $exe->atualizaEstado();
            header("Location: main.php");
            exit();
        }
        else if(isset($_POST['chPass'])){
            $valor=array_keys($_POST['chPass']);
            $strChPass='<div class="row justify-content paTop wrapper">
                    <img src="https://cdn-icons-png.flaticon.com/512/38/38464.png?w=360" class="col-1"" width="55" height="55">
                    <h1 class="col-10">GYMLOG</h1>
                </div>
                <div class="container border rounded shadow p-3 mb-5">
                <h3>'.i18n(H_CH_PASS).'</h3>
                <form method="POST" class="text-center">
                    <table class="table">
                        <tbody>
                            <tr scope="row">
                                <th><label for="oldPass">'.i18n(LABEL_CH_PASS_OLD).':</label></th>
                                <td><input id="oldPass" name="oldPass" type="password" placeholder="'.i18n(LABEL_CH_PASS_OLD).'" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="newPass">'.i18n(LABEL_CH_PASS_NEW).':</label></th>
                                <td><input id="newPass" name="newPass" type="password" placeholder="'.i18n(LABEL_CH_PASS_NEW).'" required></td>
                            </tr>
                            <tr scope="row">
                                <th><label for="newPassAgain">'.i18n(LABEL_CH_PASS_NEW_AGAIN).':</label></th>
                                <td><input id="newPassAgain" name="newPassAgain" type="password" placeholder="'.i18n(LABEL_CH_PASS_NEW_AGAIN).'" required></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" class="btn btn-primary" name="chPassConf['.$valor[0].']" value="'.i18n(CH_PASS_BUTTON_CONF).'">
                </form>
                <form method="POST">
                    <input type="submit" class="btn btn-secondary" name="backMain" value="'.i18n(BACK_BUTTON).'">
                </form>
                </div>';
            echo $strBoot.''.$strChPass;

        }
        if(isset($_POST["exerciseAdded"])){
            if(isset($_POST["nameExercise"]) && isset($_POST["descExercise"]) && isset($_FILES["photoExercise"]) 
            && isset($_POST["musclesExercise"]) && isset($_POST["repsExercise"])){
                if(!(empty($_POST["nameExercise"]) || empty($_POST["descExercise"]) || empty($_FILES["photoExercise"])
                        || empty($_POST["musclesExercise"]) || empty($_POST["repsExercise"]))){
                    
                    $ext = ["image/png" => ".png", "image/jpeg" => ".jpg" ];
                    $pho=md5(date("YmdHis")).md5($_SESSION["login"]).$ext[$_FILES["photoExercise"]["type"]];

                    $exe = new exercicio($_POST["nameExercise"],$_POST["descExercise"],$pho,$_POST["musclesExercise"],$_POST["repsExercise"]);
                    $exe->insereExercicio();
                    if (!move_uploaded_file($_FILES["photoExercise"]["tmp_name"], "./".$pho)){
                        print("Ocorreu um erro a copiar o ficheiro"); 
                    }            
                    header("Location: main.php?successAddExe=true");
                    exit();
                    
                }
            }
        }
        if(isset($_POST["exerciseEdited"])){
            if(isset($_POST["nameExerciseEdit"]) && isset($_POST["descExerciseEdit"]) && isset($_FILES["photoExerciseEdit"]) 
                && isset($_POST["musclesExerciseEdit"]) && isset($_POST["repsExerciseEdit"])){
                    if(!(empty($_POST["nameExerciseEdit"]) || empty($_POST["descExerciseEdit"]) || empty($_FILES["photoExerciseEdit"])
                            || empty($_POST["musclesExerciseEdit"]) || empty($_POST["repsExerciseEdit"]))){

                        $valor=array_keys($_POST['exerciseEdited']);
                        $gereEx = new gereExercicio();
                        $exe=$gereEx->pesquisaExercicios($valor[0]);
                        
                        $ext = ["image/png" => ".png", "image/jpeg" => ".jpg" ];
                        echo $_FILES["photoExerciseEdit"]["type"];
                        $pho=md5(date("YmdHis")).md5($_SESSION["login"]).$ext[$_FILES["photoExerciseEdit"]["type"]];
                        $exe->editaExercicio($_POST["nameExerciseEdit"],$_POST["descExerciseEdit"],$pho,
                                                $_POST["musclesExerciseEdit"],$_POST["repsExerciseEdit"]);
                        if (!move_uploaded_file($_FILES["photoExerciseEdit"]["tmp_name"], "./".$pho)){
                            print("Ocorreu um erro a copiar o ficheiro"); 
                        }
                        header("Location: main.php?successEditExe=true");
                        exit(); 
                    }
                }
        }
        if(isset($_POST["chPassConf"])){
            if(isset($_POST["oldPass"]) && isset($_POST["newPass"])){
                if(!(empty($_POST["oldPass"]) || empty($_POST["newPass"]))){
                    $valor=array_keys($_POST['chPassConf']);
                    $gereUs = new gereUtilizador();
                    $admin=$gereUs->pesquisaAdmin($valor[0]);
                    $veri=$admin->verificaPassOld($_POST["oldPass"]);
                    if($veri){
                        if($_POST['newPass']==$_POST['newPassAgain']){
                            $admin->alterarPass($_POST["newPass"]);
                            $admin->setPass($_POST["newPass"]);

                            header("Location: main.php?successChPass=1");
                            exit();
                        }
                        else{
                            header("Location: main.php?successChPass=2");
                            exit();
                        }
                    }
                    else{
                        header("Location: main.php?successChPass=3");
                        exit();
                    } 
                }
            }
        }
        if(isset($_POST["backMain"])){
            header("Location: main.php");
            exit();
        }
    }
    else{
        echo $strBoot.'
        <form method="POST" class="text-center" action="formulario.php">
            <h3>'.i18n(MSG_ERROR_SESSION).'</h3>
            <input type="submit" class="btn btn-secondary" name="backLogin" value="'.i18n(ERROR_SESSION_BACK_BUTTON).'">
        </form>';
    }
    
    

?>