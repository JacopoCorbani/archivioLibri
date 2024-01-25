<?php 
    include "connessione.php";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if(mysqli_connect_errno()){
        echo "connessione falita: ". die(mysqli_connect_error());
    }
    $query = "SELECT * FROM autori ORDER BY cognome";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $autori = array();
        while ($autore = mysqli_fetch_assoc($risultato)) {
            $autori[] = $autore;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }

    $query = "SELECT * FROM generi ORDER BY genere";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $generi = array();
        while ($genere = mysqli_fetch_assoc($risultato)) {
            $generi[] = $genere;
        }
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }
<<<<<<< Updated upstream

=======
    //po
>>>>>>> Stashed changes
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Libreria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary"  style="padding: 0;">
            <div class="container-fluid " style="background-color: rgb(0, 153, 255);">
                <a class="navbar-brand">Archivio</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" href="menu.php">Libri</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" href="aggiungiPrestito.php">Prestiti</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Aggiungi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="aggiungiLibro.php">Aggiungi Libro</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="aggiungiAutore.php">Aggiungi Autore</a></li>
                        <li><a class="dropdown-item" href="aggiungiGenere.php">Aggiungi Genere</a></li>
                        <li><a class="dropdown-item" href="aggiungiCasaEditrice.php">Aggiungi Casa Editrice</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Aggiungi Cliente</a></li>
                        <li><a class="dropdown-item" href="aggiungiUtente.php">Aggiungi Utente</a></li>
                    </ul>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="grid text-center">
        <div class="g-col-1"></div>
        <div class="g-col-10 contenuto">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <div class="grid text-center">
                    <div class="g-col-5">
                        <select class="form-select" aria-label="Default select example" name="autore" id="autore">
                            <option selected value="">seleziona un autore</option>
                            <?php 
                                for ($i=0; $i < count($autori); $i++) { 
                                    $cf = $autori[$i]['cf'];
                                    $nome = $autori[$i]['nome'];
                                    $cognome = $autori[$i]['cognome'];
                                    echo "<option value='$cf'>$cognome $nome</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="g-col-5">
                        <select class="form-select" aria-label="Default select example" name="genere" id="genere">
                            <option selected value="">seleziona un genere</option>
                            <?php 
                                for ($i=0; $i < count($generi); $i++) { 
                                    $id = $generi[$i]['id'];
                                    $genere = $generi[$i]['genere'];
                                    echo "<option value='$id'>$genere</option>";
                                }
                            ?>
                        </select>
                    </div> 
                    <div class="g-col-1">
                        <button type="submit" class="btn btn-primary">Cerca</button>
                    </div>
                    <div class="g-col-1">
                        <button type="submit" class="btn btn-primary" value="reset" name="reset">Reset</button>
                    </div>
                </div>
                </form>
            <div>
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
                            if(isset($_POST["reset"])){
                                unset($_POST["autore"]);
                                unset($_POST["genere"]);
                            }
                            include "connessione.php";
                            $conn = mysqli_connect($hostname, $username, $password, $dbname);
                            if(mysqli_connect_errno()){
                                echo "connessione falita: ". die(mysqli_connect_error());
                            }
                            $query = "SELECT 
                                        libri.titolo,
                                        GROUP_CONCAT(autori.cognome,' ', autori.nome) AS autore, 
                                        generi.genere, 
                                        libri.prezzo, 
                                        libri.anno_publicazione, 
                                        GROUP_CONCAT(nazioni.nome_nazione) AS nazionalita,
                                        casa_editrice.nome AS casa_editrice, 
                                        libri.ISBN
                                        
                                        FROM 
                                            libri
                                            INNER JOIN autori_libri ON libri.ISBN = autori_libri.ISBN_Libro
                                            INNER JOIN autori ON  autori_libri.cf_autore = autori.cf
                                            INNER JOIN generi ON libri.genere = generi.id
                                            INNER JOIN casa_editrice ON libri.id_casa_editrice = casa_editrice.id
                                            INNER JOIN nazioni ON autori.`nazionalità` = nazioni.id";
                            $c = false;
                            if(isset($_POST["autore"]) && $_POST["autore"] != ''){
                                $nome = $_POST["autore"];
                                $query .= " WHERE autori.cf = '$nome' ";
                                $c = true;
                            }
                            if(isset($_POST["genere"]) && $_POST["genere"] != ''){
                                $genere = $_POST["genere"];
                                if($c){
                                    $query .= " AND generi.id = $genere ";
                                }else{
                                    $query .= " WHERE generi.id = $genere ";
                                }
                            }
                            $query .= " GROUP BY libri.ISBN;";
                            //echo $query;
                            $risultato = mysqli_query($conn, $query);
                        
                            if ($risultato) {
                                $libri = array();
                                while ($libro = mysqli_fetch_assoc($risultato)) {
                                    $libri[] = $libro;
                                }
                            } else {
                                echo "Errore nella query: " . mysqli_error($conn);
                            }
                        
                            mysqli_close($conn);
                            for ($i=0; $i < count($libri) ; $i++) { 
                                $titolo = $libri[$i]['titolo'];
                                $autore = $libri[$i]['autore'];
                                $genere = $libri[$i]['genere'];
                                $prezzo = $libri[$i]['prezzo'];
                                $anno_publicazione = $libri[$i]['anno_publicazione'];
                                $nazioni = $libri[$i]['nazionalita'];
                                $casa_editrice = $libri[$i]['casa_editrice'];
                                $ISBN = $libri[$i]['ISBN'];
        
                                echo "<tr><td>$titolo</td><td>$autore</td><td>$genere</td><td>$prezzo €</td><td>$anno_publicazione</td><td>$nazioni</td><td>$casa_editrice</td><td>$ISBN</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="g-col-1"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#libri');
<<<<<<< Updated upstream
=======
        console.log("porco dutos");
>>>>>>> Stashed changes
    </script>
</body>
</html> 
