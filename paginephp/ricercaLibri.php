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

    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Ricerca Libri</title>
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi un libro
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
            <input type="radio" name="tipoRicerca" value="0" onclick="abilitaDisabilataSelect(0)">
            <label for="tipoRicerca">Ricerca per autore</label><br>

            <input type="radio" name="tipoRicerca" value="1" onclick="abilitaDisabilataSelect(1)">
            <label for="tipoRicerca">Ricerca per genere</label><br>

            <input type="radio" name="tipoRicerca" value="2" onclick="abilitaDisabilataSelect(2)">
            <label for="tipoRicerca">Libri italiani</label><br>

            <input type="radio" name="tipoRicerca" value="3" onclick="abilitaDisabilataSelect(3)">
            <label for="tipoRicerca">Ricerca per autore e genere</label><br>

            <select name="autore" id="autore">
                <option value="">seleziona un autore</option>
                <?php 
                    for ($i=0; $i < count($autori); $i++) { 
                        $cf = $autori[$i]['cf'];
                        $nome = $autori[$i]['nome'];
                        $cognome = $autori[$i]['cognome'];
                        echo "<option value='$cf'>$nome $cognome</option>";
                    }
                ?>
            </select>
            <select name="genere" id="genere">
                <option value="">Seleziona il genere</option>
                <?php 
                    for ($i=0; $i < count($generi); $i++) { 
                        $id = $generi[$i]['id'];
                        $genere = $generi[$i]['genere'];
                        echo "<option value='$id'>$genere</option>";
                    }
                ?>
            </select><br>

            <input type="submit" value="Cerca">
        </form>
        <script>
            function abilitaDisabilataSelect(n){
                const selectAutore = document.getElementById('autore');
                const selectGenere = document.getElementById('genere');
                switch (n) {
                    case 0:
                        selectAutore.disabled = false;
                        selectGenere.disabled = true;
                        break;
                    case 1:
                        selectAutore.disabled = true;
                        selectGenere.disabled = false;
                        break;
                    case 2:
                        selectAutore.disabled = true;
                        selectGenere.disabled = true;
                        break;
                    case 3:
                        selectAutore.disabled = false;
                        selectGenere.disabled = false;
                        break;                
                    default:
                        break;
                }
            }
        </script>
        <div id="ricerca">
            <?php 
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipoRicerca'])){
                $conn = mysqli_connect($hostname, $username, $password, $dbname);
                if(mysqli_connect_errno()){
                    echo "connessione falita: ". die(mysqli_connect_error());
                }             
                
                switch ($_POST['tipoRicerca']) {
                    case 0:
                        if(isset($_POST["autore"])){
                            $autore = $_POST["autore"];
                            
                            $query = "SELECT * FROM libri INNER JOIN autori_libri ON libri.ISBN = autori_libri.ISBN_Libro WHERE autori_libri.cf_autore = '$autore'";
                            $risultato = mysqli_query($conn, $query);
                            
                            if ($risultato) {
                                $libri = array();
                                while ($libro = mysqli_fetch_assoc($risultato)) {
                                    $libri[] = $libro;
                                }
                            } else {
                                echo "Errore nella query: " . mysqli_error($conn);
                            }
                        }
                        break;
                    case 1:
                        if(isset($_POST["genere"])){
                            $genere = $_POST["genere"];
                            
                            $query = "SELECT * FROM libri WHERE genere = '$genere'";
                            $risultato = mysqli_query($conn, $query);
                            
                            if ($risultato) {
                                $libri = array();
                                while ($libro = mysqli_fetch_assoc($risultato)) {
                                    $libri[] = $libro;
                                }
                            } else {
                                echo "Errore nella query: " . mysqli_error($conn);
                            }
                        }
                        break;
                    case 2:
                        $query = "SELECT * FROM libri INNER JOIN autori_libri ON libri.ISBN = autori_libri.ISBN_Libro INNER JOIN autori ON autori_libri.cf_autore = autori.cf INNER JOIN nazioni ON autori.nazionalità = nazioni.id WHERE nome_nazione = 'Italia'";
                        $risultato = mysqli_query($conn, $query);
                        
                        if ($risultato) {
                            $libri = array();
                            while ($libro = mysqli_fetch_assoc($risultato)) {
                                $libri[] = $libro;
                            }
                        } else {
                            echo "Errore nella query: " . mysqli_error($conn);
                        }
                        break;
                    case 3:
                        if(isset($_POST["autore"]) && isset($_POST["genere"])){
                            $autore = $_POST["autore"];
                            $genere = $_POST["genere"];
                            
                            $query = "SELECT * FROM libri INNER JOIN autori_libri ON libri.ISBN = autori_libri.ISBN_Libro WHERE autori_libri.cf_autore = '$autore' AND genere = '$genere'";
                            $risultato = mysqli_query($conn, $query);
                            
                            if ($risultato) {
                                $libri = array();
                                while ($libro = mysqli_fetch_assoc($risultato)) {
                                    $libri[] = $libro;
                                }
                            } else {
                                echo "Errore nella query: " . mysqli_error($conn);
                            }
                        }
                        break;
                        
                        default:
                        
                        break;
                    }
                    mysqli_close($conn);
                    echo "<table>";
                    echo "<thead><tr><th>Titolo</th><th>Autore</th><th>Genere</th><th>Prezzo</th><th>anno di publicazione</th><th>Nazionalita'</th><th>Casa editrice</th><th>ISBN</th></tr></thead>";
                    echo "<tbody>";
                    for ($i=0; $i < count($libri) ; $i++) { 
                        $titolo = $libri[$i]['titolo'];

                        $autori = cercaAutore($libri[$i]['ISBN']);
                        $autore = "";
                        foreach ($autori as $a) {
                            $autore .= $a['nome']." ".$a['cognome']." ";
                        }

                        $genere = cercaGenere($libri[$i]['genere']);
                        $prezzo = $libri[$i]['prezzo'];
                        $anno_publicazione = $libri[$i]['anno_publicazione'];

                        $nazioni = cercaNazione($libri[$i]['ISBN']);
                        //var_dump($nazioni);
                        $nazionalita = "";
                        foreach ($nazioni as $n) {
                            $nazionalita .= $n['nome_nazione']." ";
                        }
                        
                        
                        $casa_editrice = cercaCasaEditrice($libri[$i]['id_casa_editrice']);
                        $ISBN = $libri[$i]['ISBN'];

                        echo "<tr><td>$titolo</td><td>$autore</td><td>$genere</td><td>$prezzo €</td><td>$anno_publicazione</td><td>$nazionalita</td><td>$casa_editrice</td><td>$ISBN</td></tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    
                }
                ?>
        </div>
    </div>

</body>
</html>
<?php 
    function cercaAutore($ISBN){
        include "connessione.php";
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(mysqli_connect_errno()){
            echo "connessione falita: ". die(mysqli_connect_error());
        }
        $query = "SELECT nome, cognome FROM autori INNER JOIN autori_libri ON autori.cf = autori_libri.cf_autore INNER JOIN libri ON autori_libri.ISBN_Libro = libri.ISBN WHERE ISBN = '$ISBN'";
        $risultato = mysqli_query($conn, $query);
        
        if ($risultato) {
            $autori = array();
            while ($autore = mysqli_fetch_assoc($risultato)) {
                $autori[] = $autore;
            }
            //var_dump($autori);
        } else {
            echo "Errore nella query: " . mysqli_error($conn);
        }

        mysqli_close($conn);
        return $autori;
    }
    function cercaGenere($id){
        include "connessione.php";
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(mysqli_connect_errno()){
            echo "connessione falita: ". die(mysqli_connect_error());
        }

        $query = "SELECT genere FROM generi WHERE id = '$id'";
        $risultato = mysqli_query($conn, $query);

        $genere = mysqli_fetch_assoc($risultato);

        mysqli_close($conn);
        //var_dump($genere);
        return $genere['genere'];
    }

    function cercaNazione($ISBN){
        include "connessione.php";
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(mysqli_connect_errno()){
            echo "connessione falita: ". die(mysqli_connect_error());
        }

        $query = "SELECT nome_nazione FROM nazioni INNER JOIN autori on nazioni.id = autori.nazionalità INNER JOIN autori_libri on autori.cf = autori_libri.cf_autore INNER JOIN libri ON autori_libri.ISBN_Libro = libri.ISBN WHERE ISBN = '$ISBN'";
        $risultato = mysqli_query($conn, $query);

        if ($risultato) {
            $nazioni = array();
            while ($nazione = mysqli_fetch_assoc($risultato)) {
                $nazioni[] = $nazione;
            }
            //var_dump($nazioni);
        } else {
            echo "Errore nella query: " . mysqli_error($conn);
        }

        mysqli_close($conn);
        //var_dump($nazioni);
        return $nazioni;
    }

    function cercaCasaEditrice($id){
        include "connessione.php";
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(mysqli_connect_errno()){
            echo "connessione falita: ". die(mysqli_connect_error());
        }

        //$query = "SELECT nome FROM casa_editrice INNER JOIN libri on casa_editrice.id = libri.id_casa_editrice WHERE ISBN = '$ISBN'";
        $query = "SELECT nome FROM casa_editrice WHERE id = '$id'";

        $risultato = mysqli_query($conn, $query);

        $casaEditrice = mysqli_fetch_assoc($risultato);

        mysqli_close($conn);
        //var_dump($casaEditrice);
        return $casaEditrice['nome'];
    }
?>