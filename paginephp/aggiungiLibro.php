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
    $datiAutori = array();
    for ($i=0; $i < count($autori); $i++) { 
        $cf = $autori[$i]['cf'];
        $nome = $autori[$i]['nome'];
        $cognome = $autori[$i]['cognome'];
        $array = array(
        "cf" => $cf,
        "nome" => $nome,
        "cognome" => $cognome
    );
    $datiAutori[] = $array;
    //echo "nome autori" . $array;
    //echo "<option value='$cf'>$cognome $nome</option>";
    //echo "<li class="checkboxAutore"><div class="form-check"><input class="form-check-input" type="checkbox" name="autore" value="$cf" id="flexCheckDefault"><label class="form-check-label" for="flexCheckDefault" >$cognome $nome</label></div></li>";
  }
  //var_dump($datiAutori);
  global $autoriJson;
  $autoriJson = json_encode($datiAutori);
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
        <nav class="navbar navbar-expand-lg bg-body-tertiary" style="padding: 0;">
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
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formLibro">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="isbn">
                    <label for="isbn">ISBN</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="titolo" name="titolo" placeholder="titolo">
                    <label for="titolo">Titolo</label>
                </div>

                <div class="grid text-center" id="ricarica">
                    <div class="g-col-8">
                        <div class="dropdown" >
                            <button class="btn btn-secondary dropdown-toggle" style="min-width: 100%; background-color: white; color:black;"; type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleziona autori
                            </button>
                            <ul class="dropdown-menu">
                                <li style="padding: 5px;">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Autore</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="inputRicerca" oninput="ricerca()">
                                    </div>
                                </li>
                                <div id="autori">
                    
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="g-col-4">
                        <button type="button" class="btn btn-primary" onclick="aggiungiAutore()">Aggiungi Autore</button><br>
                    </div>
                </div><br>
                
                <select class="form-select" aria-label="Default select example" name="genere" id="genere">
                    <option selected value="">seleziona un genere</option>
                    <?php 
                        for ($i=0; $i < count($generi); $i++) { 
                            $id = $generi[$i]['id'];
                            $genere = $generi[$i]['genere'];
                            echo "<option value='$id'>$genere</option>";
                        }
                    ?>
                </select><br>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="prezzo" name="prezzo" placeholder="prezzo">
                    <label for="prezzo">Prezzo</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="anno_publicazione" name="anno_publicazione" placeholder="anno_publicazione">
                    <label for="anno_publicazione">Anno di Pubblicazione:</label>
                </div>
                <select class="form-select" aria-label="Default select example" name="casa_editrice" id="casa_editrice">
                    <option selected value="">seleziona una casa editrice</option>
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
            var autore = document.getElementById('flexCheckDefault').value;
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
    <script>
      chekkati = []
      function cheka(id){
        if(chekkati.includes(id)){
          const i = chekkati.indexOf(id)
          chekkati.splice(i, 1)
        }else{
          chekkati.push(id)
        }
      }
      function richiediArrayAutori(){
        return <?php echo $autoriJson; ?>;
      }
      caricaSelect()
      function caricaSelect(){
        const arrayAutori = richiediArrayAutori();
        const div = document.getElementById('autori')
        div.innerHTML = "";
        console.log(arrayAutori)

        arrayAutori.forEach(autore => {
          let str = "";
          if(chekkati.includes(autore["cf"])){
            str = "checked"
          }else{
            str = "";
          }
          div.innerHTML += `<li class="checkboxAutore" style="padding: 5px;">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" ${str} onchange="cheka('${autore["cf"]}')" name="autore[]" value="${autore["cf"]}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault" >${autore["cognome"] + " " + autore["nome"]}</label>
                              </div>
                            </li>`;
        });
      }
      function ricerca(){
        const div = document.getElementById('autori')
        const autori = <?php echo $autoriJson; ?>;
        const testo = document.getElementById('inputRicerca').value.toUpperCase();

        if(testo === ''){
          caricaSelect()
        }else{
          div.innerHTML = "";
          Array.from(autori).forEach(autore => {
            const nomeAutore = (autore["cognome"] + " " + autore["nome"]).toUpperCase();
            
            if (nomeAutore.includes(testo)) {
              console.log(nomeAutore + ' -> ' + testo)
              let str = "";
              console.log(chekkati);
              if(chekkati.includes(autore["cf"])){
                str = "checked"
              }else{
                str = "";
              }
              div.innerHTML += `<li class="checkboxAutore" style="padding: 5px;">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" ${str} onchange="cheka('${autore["cf"]}')" name="autore[]" value="${autore["cf"]}" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault" >${autore["cognome"] + " " + autore["nome"]}</label>
                                  </div>
                                </li>`;
            }
          });
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