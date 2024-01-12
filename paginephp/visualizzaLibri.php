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

    $query = "SELECT * FROM nazioni";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $nazioni = array();
        while ($nazione = mysqli_fetch_assoc($risultato)) {
            $nazioni[] = $nazione;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
    <div id="contenuto" class="didplay">
        <table id="libri">
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Autore</th>
                    <th>Genere</th>
                    <th>Prezzo</th>
                    <th>anno di publicazione</th>
                    <th>Nazionalita'</th>
                    <th>Casa editrice</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
                <?php 
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
                                        $nazionalita = $nazioni[array_search($a['nazionalità'], array_column($nazioni, 'id'))]['nome_nazione'];
                                        $autore .= $a['nome']." ".$a['cognome']."  ";
                                    }
                                }
                            }
                        }
                        echo "<tr><td>$titolo</td><td>$autore</td><td>$genere</td><td>$prezzo €</td><td>$anno_publicazione</td><td>$nazionalita</td><td>$casa_editrice</td><td>$ISBN</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#libri');
    </script>
</body>
</html>