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

    $query = "SELECT * FROM clienti";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $clienti = array();
        while ($cliente = mysqli_fetch_assoc($risultato)) {
            $clienti[] = $cliente;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }

    $query = "SELECT * FROM libri";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $libri = array();
        while ($libro = mysqli_fetch_assoc($risultato)) {
            $libri[] = $libro;
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
    <title>Aggiungi prestito</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi prestito
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formPrestito">
            
            <label for="libro">Libro:</label>
            <select name="libro" id="libro">
                <option value="">scegli il libro</option>
                    <?php 
                        for ($i=0; $i < count($libri); $i++) { 
                            $ISBN = $libri[$i]['ISBN'];
                            $titolo = $libri[$i]['titolo'];

                            $query = "SELECT data_fine FROM prestiti WHERE ISBN_Libro = '$ISBN'";
                            $risultato = mysqli_query($conn, $query);

                            //echo (($risultato && mysqli_num_rows($risultato) >0) ? mysqli_fetch_assoc($risultato)['data_fine'] : "");
                            if($risultato && mysqli_num_rows($risultato) > 0){
                                //var_dump(mysqli_fetch_assoc($risultato)['data_fine']);
                                $data_fine = mysqli_fetch_assoc($risultato)['data_fine'];
                                echo $data_fine;
                                $data = new DateTime();
                                $data->format('Y-m-d');
                                echo "--".$data->diff(new DateTime($data_fine))->invert."--";
                                if($data->diff(new DateTime($data_fine))->invert <= 0){// il libro è in prestito
                                    echo "in prestito";
                                    echo "<option value='$ISBN' disabled>$titolo</option>";
                                }else{
                                    echo "<option value='$ISBN'>$titolo</option>";
                                }
                            }else{
                                echo "<option value='$ISBN'>$titolo</option>";
                            }

                        }
                    ?>
            </select><br>
    
            <label for="cliente">Cliente:</label>
            <select name="cliente" id="cliente">
                <option value="">scegli il cliente</option>
                    <?php 
                        for ($i=0; $i < count($clienti); $i++) { 
                            $cf = $clienti[$i]['cf'];
                            $nome = $clienti[$i]['nome'];
                            $cognome = $clienti[$i]['cognome'];
                            echo "<option value='$cf'>$nome $cognome</option>";
                        }
                    ?>
            </select><br>
    
    
            <label for="dataInizio">Data inizio:</label>
            <input type="date" id="dataInizio" name="dataInizio"><br>            
    
            <label for="dataFine">Data fine</label>
            <input type="date" id="dataFine" name="dataFine"><br>
        </form>
        <button type="button" onclick="controllaForm()">Aggiungi Autore</button>
    </div>

    <script>
        function controllaForm() {
            var libro = document.getElementById('libro').value;
            var cliente = document.getElementById('cliente').value;
            var dataInizio = document.getElementById('dataInizio').value;
            var dataFine = document.getElementById('dataFine').value;

            if (libro != '' && cliente != '' && dataInizio != '' && dataFine != '') {
                document.getElementById('formPrestito').submit();
            }else{
                console.log(cf, cf.length)
                alert("Inserisci tutti i dati!!");
            }
        }
    </script>
    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $ISBN = $_POST["libro"];
            $cliente = $_POST["cliente"];
            $dataInizio = $_POST["dataInizio"];
            $dataFine = $_POST["dataFine"];

            $query = "INSERT INTO prestiti(ISBN_Libro, cf_cliente, data_inizio, data_fine) VALUES ('$ISBN', '$cliente', '$dataInizio', '$dataFine');";
            mysqli_query($conn, $query);
            mysqli_close($conn);
            echo "<br><br><h1>Prestito Aggiunto<h1>";
        }
    ?>
</body>
</html>