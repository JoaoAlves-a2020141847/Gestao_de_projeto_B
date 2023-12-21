<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="mainReserva.php">
        <input type="text" name="name" placeholder="Nome">
        <br>
        <p>ESTUDANTE:</p>
        <input type="radio" name="estudante" id="estudante" value="estudante" onclick="ativa()">
        <label for="sim" >Sim</label><br>
        <br>
        <br>
        <input type="radio" name="estudante" id="naoestudante" value="nao estudante" onclick="desativa()">
        <label for="nao">Nao</label>
        <br>
        <select name="curso" id="curso">
            <option value="lei">LEI</option>
            <option value="lsti">LSTI</option>
            <option value="marketing">MARKETING</option>
            <option value="S/ curso">S/ CURSO</option>
        </select>
        <br>
        <input type="checkbox" name="dia[]" value="Dia 1">
        <label for="dia1">dia 1 5€</label>
        <br>
        <input type="checkbox" name="dia[]" value="Dia 2">
        <label for="dia2">dia 2 6€</label>
        <br>
        <input type="checkbox" name="dia[]" value="Dia 3">
        <label for="dia3">dia 3 5€</label>
        <br>
        <input type="checkbox" name="dia[]" value="Dia 4">
        <label for="dia4">dia 4 180€</label>
        <br>
        <input type="checkbox" name="dia[]" value="Dia 5">
        <label for="dia5">dia 5 2€</label>
        <br>
        <input type="text" name="telefone" placeholder="telefone" pattern="[0-9]{1}[0-9]{8}">
        <br>

        <input type="submit" name="button" value="OK">

        <script>
            function ativa() { 
                document.getElementById("curso").disabled = false; 
            }
            function desativa(){
                    document.getElementById("curso").disabled = true;
            }
                
        </script>
    </form>
</body>
</html>