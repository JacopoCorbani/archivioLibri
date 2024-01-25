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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Aggiungi Utente</title>
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
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formUtente">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="nome">
                    <label for="nome">Data inizio:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="cognome" name="cognome" placeholder="cognome">
                    <label for="cognome">Cognome</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nomeUtente" name="nomeUtente" placeholder="nomeUtente">
                    <label for="nomeUtente">Data inizio:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="password">
                    <label for="password">password</label>
                </div>  
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="confermaPassword" name="confermaPassword" placeholder="confermaPassword">
                    <label for="confermaPassword">Conferma password</label>
                </div>
            </form>
            <button type="button" class="btn btn-primary" onclick="controllaForm()">Aggiungi Utente</button>
        </div>
        <div class="g-col-4"></div>
    </div>
    <script>
        function controllaForm(){
            const nome = document.getElementsByName('nome')[0];
            const cognome = document.getElementsByName('cognome')[0];
            const nomeUtente = document.getElementsByName('nomeUtente')[0];

            const p1 = document.getElementsByName('password')[0];
            const p2 = document.getElementsByName('confermaPassword')[0];
            if((p1.value == p2.value && p1.value != "") && nome != "" && cognome != "" && nomeUtente != ""){
                console.log("le password coincidono");
                document.getElementById('formUtente').submit();
            }else{
                console.log("le password non coincidono");
                p1.style.border = " solid red 2px";
                p2.style.border = " solid red 2px";
            }
        }
    </script>

    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $nomeUtente = $_POST["nomeUtente"];
            $password = $_POST["password"];
            $conferma = $_POST["confermaPassword"];

            $passwordCriptata = password_hash($password, PASSWORD_DEFAULT);

            if($password == $conferma && $password != ""){
                $query = "INSERT INTO utenti(nome, cognome, nomeUtente, passwordUtente) VALUES ('$nome', '$cognome', '$nomeUtente', '$passwordCriptata')";
                mysqli_query($conn, $query);
            }
            mysqli_close($conn);
        }
    ?>
    
</body>
</html>