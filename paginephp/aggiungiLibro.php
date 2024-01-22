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
    mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi libro</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/multiselect-dropdown.js"></script>
</head>
<body>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="chiudiModalBtn">&times;</span>
            <iframe src="aggiungiAutore.php" frameborder="0"></iframe>
        </div>
    </div>

    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi un libro
        </div>
    </header>
    <div id="contenuto">

        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formLibro">
            
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn"><br>          
    
            <label for="titolo">Titolo:</label>
            <input type="text" id="titolo" name="titolo"><br>

            <div id="ricarica">
                <label>Autore</label>
                <div id="autoriSelezionati">

                </div>
                <select name="autore[]" id="autore" onchange="lista()" multiple="" multiselect-hide-x="true" multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">
                    <?php 
                        for ($i=0; $i < count($autori); $i++) { 
                            $cf = $autori[$i]['cf'];
                            $nome = $autori[$i]['nome'];
                            $cognome = $autori[$i]['cognome'];
                            echo "<option value='$cf'>$nome $cognome</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="button" onclick="aggiungiAutore()">Aggiungi Autore</button><br>

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
        <button type="button" onclick="controllaForm()">Aggiungi Libro</button>
    </div>

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