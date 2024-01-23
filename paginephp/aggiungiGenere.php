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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Aggiungi genere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: rgb(0, 255, 255);">
            <div class="container-fluid" style="background-color: rgb(0, 255, 255);">
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