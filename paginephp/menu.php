<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="../index.php">Disconnettiti</a>
        </div>
        <div>
            ARCHIVIO
        </div>
    </header>
    <div id="contenuto">
        <div><a href="visualizzaLibri.php">Visualizza tutti i libri</a></div>
        <div style='margin: 10px;'><a href='ricercaLibri.php'>Ricerca Libri</a></div>
        <?php 
        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
            stampa();
        }
        function stampa(){
            echo "<div style='margin: 10px;'><a href='aggiungiLibro.php'>Aggiungi Libro</a></div>";
            echo "<div style='margin: 10px;'><a href='aggiungiAutore.php'>Aggiungi Autore</a></div>";
            echo "<div style='margin: 10px;'><a href='aggiungiGenere.php'>Aggiungi Genere</a></div>";
            echo "<div style='margin: 10px;'><a href='aggiungiCasaEditrice.php'>Aggiungi Casa Editrice</a></div>";
            echo "<div style='margin: 10px;'><a href='aggiungiPrestito.php'>Aggiungi Prestito</a></div>";
            //echo "<div style='margin: 10px;'><a href='creaTabelle.php'>Crea le tabelle nel database</a></div>";
        }
        ?>
    </div>
</body>
</html> 