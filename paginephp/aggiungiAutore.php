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

    $query = "SELECT * FROM nazioni";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $nazionalita = array();
        while ($nazione = mysqli_fetch_assoc($risultato)) {
            $nazionalita[] = $nazione;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi autore</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi autore
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formAutore">
            
            <label for="cf">Codice Fiscale:</label>
            <input type="text" id="cf" name="cf"><br>
    
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome"><br>
    
            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome"><br>
    
            <label for="nazionalita">Nazionalita'</label>
            <select name="nazionalita" id="nazionalita">
                <option value="">scegli la nazionalita</option>
                    <?php 
                            for ($i=0; $i < count($nazionalita); $i++) { 
                                $id = $nazionalita[$i]['id'];
                                $nome_nazione = $nazionalita[$i]['nome_nazione'];
                                echo "<option value='$id'>$nome_nazione</option>";
                            }
                    ?>
            </select><br>
    
            <label for="data_nascita">Data di nascita</label>
            <input type="date" id="data_nascita" name="data_nascita"><br>
        </form>
        <button type="button" onclick="controllaForm()">Aggiungi Autore</button>
    </div>

    <script>
        function controllaForm() {
            var cf = document.getElementById('cf').value;
            var nome = document.getElementById('nome').value;
            var cognome = document.getElementById('cognome').value;
            var nazionalita = document.getElementById('nazionalita').value;
            var data = document.getElementById('data_nascita').value;

            if (cf != '' && cf.length == 16 && nome != '' && cognome != '' && nazionalita != '' && data != '') {
                document.getElementById('formAutore').submit();
            }else{
                console.log(cf, cf.length)
                alert("Inserisci tutti i dati!!");
            }
        }
    </script>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $cf = $_POST["cf"];
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $nazionalita = $_POST["nazionalita"];
            $data_nascita = $_POST["data_nascita"];


            $query = "INSERT INTO autori(cf, nome, cognome, nazionalità, data_nascita) VALUES ('$cf', '$nome', '$cognome', '$nazionalita', '$data_nascita');";
            mysqli_query($conn, $query);
            mysqli_close($conn);
            echo "<br><br><h1>Autore Aggiunto<h1>";
        }
    ?>
</body>
</html>