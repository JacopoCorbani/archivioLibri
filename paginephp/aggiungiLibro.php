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

    $query = "SELECT * FROM casa_editrice ORDER BY nome";
    $risultato = mysqli_query($conn, $query);

    if ($risultato) {
        $case = array();
        while ($casa = mysqli_fetch_assoc($risultato)) {
            $case[] = $casa;
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>aggiungi libro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="chiudiModalBtn">&times;</span>
            <iframe src="aggiungiAutore.php" frameborder="0"></iframe>
        </div>
    </div>

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
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formLibro">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="isbn">
                    <label for="isbn">ISBN</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="titolo" name="titolo" placeholder="titolo">
                    <label for="titolo">Titolo</label>
                </div>

                <div id="ricarica">
                    <div id="autoriSelezionati">

                    </div>
                    <select class="form-select" onchange="lista()" aria-label="Default select example" name="autore[]" id="autore">
                        <option selected value="">scegli gli autori</option>
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
                <button type="button" class="btn btn-primary" onclick="aggiungiAutore()">Aggiungi Autore</button><br>
                
                <label for="genere">Genere</label>
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
        
                <label for="prezzo">Prezzo:</label>
                <input type="number" id="prezzo" name="prezzo" ><br>
        
                <label for="anno_publicazione">Anno di Pubblicazione:</label>
                <input type="number" id="anno_publicazione" name="anno_publicazione"><br>
        
                <label for="casa_editrice">Casa editrice</label>
                <select id="casa_editrice" name="casa_editrice">
                    <option value="">Selezione la casa editrice</option>
                    <?php 
                        for ($i=0; $i < count($case); $i++) { 
                            $id = $case[$i]['id'];
                            $nome = $case[$i]['nome'];
                            echo "<option value='$id'>$nome</option>";
                        }
                    ?>
                </select>
        
            </form>
            <button type="button" class="btn btn-primary" onclick="controllaForm()">Aggiungi Libro</button>
        </div>
        <div class="g-col-4"></div>
    </div>
    <script>
        function lista(){
            const div = document.getElementById('autoriSelezionati')
            const select = document.getElementById('autore');
            const option_selezionati = Array.from(select.selectedOptions);

            const autori_selezionati = option_selezionati.map(function(option) {
                const nome_cognome = option.textContent.trim();
                return nome_cognome;
            });

            console.log(autori_selezionati)
            div.innerHTML = "";
            if(autori_selezionati.length > 0){
                autori_selezionati.forEach(autore => {
                    div.innerHTML += `<span>${autore}; </span>`;
                });
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.getElementById('isbn').value = sessionStorage.getItem('isbn') || '';
            document.getElementById('titolo').value = sessionStorage.getItem('titolo') || '';
            document.getElementById('genere').value = sessionStorage.getItem('genere') || '';
            document.getElementById('prezzo').value = sessionStorage.getItem('prezzo') || '';
            document.getElementById('anno_publicazione').value = sessionStorage.getItem('anno_publicazione') || '';
            document.getElementById('casa_editrice').value = sessionStorage.getItem('casa_editrice') || '';

            sessionStorage.removeItem('isbn');
            sessionStorage.removeItem('titolo');
            sessionStorage.removeItem('genere');
            sessionStorage.removeItem('prezzo');
            sessionStorage.removeItem('anno_publicazione');
            sessionStorage.removeItem('casa_editrice');
        });
        var modal = document.getElementById('myModal');
        document.getElementById('chiudiModalBtn').addEventListener('click', function() {
            modal.style.display = 'none';
            sessionStorage.setItem('isbn', document.getElementById('isbn').value);
            sessionStorage.setItem('titolo', document.getElementById('titolo').value);
            sessionStorage.setItem('genere', document.getElementById('genere').value);
            sessionStorage.setItem('prezzo', document.getElementById('prezzo').value);
            sessionStorage.setItem('anno_publicazione', document.getElementById('anno_publicazione').value);
            sessionStorage.setItem('casa_editrice', document.getElementById('casa_editrice').value);
            location.reload();
        });
        function aggiungiAutore(){
            modal.style.display = 'block';
        }
        function controllaForm() {
            var isbn = document.getElementById('isbn').value;
            var autore = document.getElementById('autore').value;
            var titolo = document.getElementById('titolo').value;
            var genere = document.getElementById('genere').value;
            var prezzo = document.getElementById('prezzo').value;
            var anno_publicazione = document.getElementById('anno_publicazione').value;
            var casa_editrice = document.getElementById('casa_editrice').value;

            console.log(isbn, isbn.length, autore, titolo, genere, prezzo, anno_publicazione, casa_editrice)

            if (isbn != '' && isbn.length == 10 && autore != '' && titolo != '' && genere != '' && prezzo > 0 && anno_publicazione > 0 && casa_editrice != '') {
                document.getElementById('formLibro').submit();
            }else{
                alert("Inserisci tutti i dati!!");
            }
        }
    </script>

    <?php 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $conn = mysqli_connect($hostname, $username, $password, $dbname);
            if(mysqli_connect_errno()){
                echo "connessione falita: ". die(mysqli_connect_error());
            }
            $isbn = $_POST["isbn"];
            $autore = array();
            $autore = $_POST["autore"];
            $titolo = $_POST["titolo"];
            $genere = $_POST["genere"];
            $prezzo = $_POST["prezzo"];
            $anno_publicazione = $_POST["anno_publicazione"];
            $casa_editrice = $_POST["casa_editrice"];

            $query = "INSERT INTO libri(ISBN, titolo, genere, prezzo, anno_publicazione, id_casa_editrice) VALUES 
                    ('$isbn', '$titolo', $genere, $prezzo, $anno_publicazione, $casa_editrice);";
            mysqli_query($conn, $query);
            foreach($autore as $id){
                $query = "INSERT INTO autori_libri(ISBN_Libro, cf_autore) VALUES ('$isbn', '$id')";
                mysqli_query($conn, $query);
            }
            mysqli_close($conn);
            echo "<br><br><h1>Libro Aggiunto<h1>";
        }
    ?>
</body>
</html>