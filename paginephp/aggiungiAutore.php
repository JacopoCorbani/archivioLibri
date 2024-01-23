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

    $query = "SELECT * FROM nazioni ORDER BY nome_nazione";
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Aggiungi Autore</title>
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
    <div class="grid text-center">
        <div class="g-col-4"></div>
        <div class="g-col-4 contenuto">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formAutore">
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="cf" name="cf" placeholder="Codice Fiscale">
                    <label for="cf">Codice Fiscale</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                    <label for="nome">Nome</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome">
                    <label for="cognome">Cognome</label>
                </div>
                <select class="form-select" aria-label="Default select example" name="nazionalita" id="nazionalita">
                    <option selected value="">scegli la nazione</option>
                    <?php 
                        for ($i=0; $i < count($nazionalita); $i++) { 
                            $id = $nazionalita[$i]['id'];
                            $nome_nazione = $nazionalita[$i]['nome_nazione'];
                            echo "<option value='$id'>$nome_nazione</option>";
                        }
                    ?>
                </select><br>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="data_nascita" name="data_nascita" placeholder="Data di nascita">
                    <label for="data_nascita">Data di nascita</label>
                </div>
            </form>
            <button type="button" class="btn btn-primary" onclick="controllaForm()">Aggiungi Autore</button>
        </div>
        <div class="g-col-4"></div>
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