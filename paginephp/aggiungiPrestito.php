<?php 
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
        
    }else{
        header("Location: ../index.php");
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Aggiungi prestito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary"  style="padding: 0;">
            <div class="container-fluid" style="background-color: rgb(0, 153, 255);">
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
        <div class="g-col-4"></div>
        <div class="g-col-4 contenuto">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formPrestito">
                <select class="form-select" aria-label="Default select example" name="libro" id="libro">
                    <option selected value="">seleziona un libro</option>
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
                <select class="form-select" aria-label="Default select example" name="cliente" id="cliente">
                    <option selected value="">seleziona un cliente</option>
                    <?php 
                        for ($i=0; $i < count($clienti); $i++) { 
                            $cf = $clienti[$i]['cf'];
                            $nome = $clienti[$i]['nome'];
                            $cognome = $clienti[$i]['cognome'];
                            echo "<option value='$cf'>$nome $cognome</option>";
                        }
                    ?>
                </select><br>   
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="dataInizio" name="dataInizio" placeholder="dataInizio">
                    <label for="dataInizio">Data inizio:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="dataFine" name="dataFine" placeholder="dataFine">
                    <label for="dataFine">Data fine:</label>
                </div>   
            </form>
            <button type="button" class="btn btn-primary" onclick="controllaForm()">Aggiungi Prestito</button>
        </div>
        <div class="g-col-4"></div>
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