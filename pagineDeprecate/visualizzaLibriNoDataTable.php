<?php 
    include "connessione.php";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if(mysqli_connect_errno()){
        echo "connessione falita: ". die(mysqli_connect_error());
    }
    $query = "SELECT * FROM autori";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $autori = array();
        while ($autore = mysqli_fetch_assoc($risultato)) {
            $autori[] = $autore;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }
    $query = "SELECT * FROM generi";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $generi = array();
        while ($genere = mysqli_fetch_assoc($risultato)) {
            $generi[] = $genere;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }

    $query = "SELECT * FROM casa_editrice";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $case = array();
        while ($casa = mysqli_fetch_assoc($risultato)) {
            $case[] = $casa;
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

    $query = "SELECT * FROM autori_libri";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $scrittori = array();
        while ($scrittore = mysqli_fetch_assoc($risultato)) {
            $scrittori[] = $scrittore;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Libri</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Visualizza i Libri
        </div>
    </header>
    <div id="contenuto">
        <div>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <input type="text" placeholder="titolo" name="titolo">
                <select name="autore" id="autore">
                    <option value="">Seleziona un autore</option>
                    <?php 
                        for ($i=0; $i < count($autori); $i++) { 
                            $cf = $autori[$i]['cf'];
                            $nome = $autori[$i]['nome'];
                            $cognome = $autori[$i]['cognome'];
                            $string = $nome." ".$cognome;
                            echo "<option value='$string'>$string</option>";
                        }
                    ?>
                </select>
                <select name="genere" id="genere">
                <option value="">Seleziona il genere</option>
                <?php 
                    for ($i=0; $i < count($generi); $i++) { 
                        $id = $generi[$i]['id'];
                        $genere = $generi[$i]['genere'];
                        echo "<option value='$genere'>$genere</option>";
                    }
                ?>
                </select>
                <select name="naziolita" id="nazionalita" name="nazionalita">
                    <option value="">Seleziona la nazionalita'</option>
                    <?php 
                        $nazionalita = array();
                        for ($i=0; $i < count($autori); $i++) {
                            $n = $autori[$i]['nazionalità'];
                            if(!in_array($n, $nazionalita)){
                                $nazionalita[] = $n;
                                echo "<option value='$n'>$n</option>";
                            }
                        }
                    ?>
                </select>
                <input type="submit" value="Cerca">
            </form>
        </div>
    <?php 
        echo "<table>";
        echo "<tr><th>Titolo</th><th>Autore</th><th>Genere</th><th>Prezzo</th><th>anno di publicazione</th><th>Nazionalita'</th><th>Casa editrice</th><th>ISBN</th>";
        for ($i=0; $i < count($libri) ; $i++) { 
            $titolo = $libri[$i]['titolo'];
            $autore = "";
            $id_genere = $libri[$i]['genere'];
            $prezzo = $libri[$i]['prezzo'];
            $anno_publicazione = $libri[$i]['anno_publicazione'];
            $nazionalita = "";
            $id_casa_editrice = $libri[$i]['id_casa_editrice'];
            $ISBN = $libri[$i]['ISBN'];
            $genere = $generi[array_search($id_genere, array_column($generi, 'id'))]['genere'];
            $casa_editrice = $case[array_search($id_casa_editrice, array_column($case, 'id'))]['nome'];
            foreach ($scrittori as $scrittore) {
                if($scrittore['ISBN_Libro'] == $ISBN){
                    foreach ($autori as $a) {
                        if($a['cf'] == $scrittore['cf_autore']){
                            $nazionalita = $a['nazionalità'];
                            $autore .= $a['nome']." ".$a['cognome']."  ";
                        }
                    }
                }
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $dati = [
                    'titolo' => $titolo,
                    'autore' => $autore,
                    'genere' => $genere,
                    'nazionalita' => $nazionalita,
                    // Aggiungi altri campi se necessario
                ];
            
                // Array di campi da cercare
                $campiDaCercare = ['titolo', 'autore', 'genere', 'nazionalita'];
            
                // Array per le condizioni di ricerca
                $condizioni = [];
            
                // Costruisci le condizioni di ricerca
                foreach ($campiDaCercare as $campo) {
                    if (isset($_POST[$campo]) && isset($dati[$campo]) && $_POST[$campo] != "") {
                        $valoreCercato = $_POST[$campo];
                        $valoreDato = $dati[$campo];
                        
                        // Aggiungi una condizione alla query solo se il campo è presente e il valore corrisponde
                        if (stripos($valoreDato, $valoreCercato) !== false) {
                            echo "<tr><td>$titolo</td><td>$autore</td><td>$genere</td><td>$prezzo €</td><td>$anno_publicazione</td><td>$nazionalita</td><td>$casa_editrice</td><td>$ISBN</td></tr>";
                        }
                    }
                }                
            }else{
                echo "<tr><td>$titolo</td><td>$autore</td><td>$genere</td><td>$prezzo €</td><td>$anno_publicazione</td><td>$nazionalita</td><td>$casa_editrice</td><td>$ISBN</td></tr>";
            }
        }
        echo "</table>";
    ?>
    </div>
</body>
</html>