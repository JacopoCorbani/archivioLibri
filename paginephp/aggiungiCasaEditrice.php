<?php 
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
        
    }else{
        header("Location: menu.php");
        exit;
    }
    include "connessione.php";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if(mysqli_connect_errno()){
        echo "connessione falita: ". die(mysqli_connect_error());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Casa Editrice</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi Casa editrice
        </div>
    </header>
    <div id = "contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formAutore">
    
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"><br>
    
            <label for="via">Via</label>
            <input type="text" id="via" name="via"><br>
    
            <label for="citta">Citta'</label>
            <input type="text" id="citta" name="citta"><br>
        </form>
        <button type="button" onclick="controllaForm()">Aggiungi Casa editrice</button>
    </div>

    <script>
        function controllaForm() {
            var nome = document.getElementById('nome').value;
            var via = document.getElementById('via').value;
            var citta = document.getElementById('citta').value;

            if (nome != '' && via != '' && citta != '') {
                document.getElementById('formAutore').submit();
            }else{
                console.log(cf, cf.length)
                alert("Inserisci tutti i dati!!");
            }
        }
    </script>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nome = $_POST["nome"];
            $via = $_POST["via"];
            $citta = $_POST["citta"];

            $query = "INSERT INTO casa_editrice(nome, via, citta) VALUES ('$nome', '$via', '$citta');";
            mysqli_query($conn, $query);
            mysqli_close($conn);
            echo "<br><br><h1>Casa Editrice Aggiunta<h1>";
        }
    ?>
</body>
</html>