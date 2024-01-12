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
    <title>Aggiungi Genere</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi genere
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formAutore">
    
            <label for="genere">Genere:</label>
            <input type="text" id="genere" name="genere">
        </form>
        <button type="button" onclick="controllaForm()">Aggiungi Genere</button>
    </div>

    <script>
        function controllaForm() {
            var genere = document.getElementById('genere').value;

            if (genere != '') {
                document.getElementById('formAutore').submit();
            }else{
                console.log(cf, cf.length)
                alert("Inserisci tutti i dati!!");
            }
        }
    </script>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $genere = $_POST["genere"];

            $query = "INSERT INTO generi(genere) VALUES ('$genere');";
            mysqli_query($conn, $query);
            mysqli_close($conn);
            echo "<br><br><h1>Genere aggiunto<h1>";
        }
    ?>
</body>
</html>