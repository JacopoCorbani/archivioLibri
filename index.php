<?php 
    session_start();
    $_SESSION['login'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <div></div>
        <div>
            ACCEDI ALL'ARCHIVIO
        </div>
    </header>
    <div id="contenuto">
        <div style="margin: 10px;">
            Accedi
            <form id="formpassword" method="POST" action="paginephp/controllapassword.php">
                <input type="text" placeholder="nome utente" name="utente"><br>
                <input id="password" type="password" placeholder="password" name="password"><br>
                <input type="submit" value="Accedi">
            </form>
        </div>
        <div><a href="paginephp/menu.php">Continua come ospite</a></div>
        <div>
            <?php 
                if(isset($_SESSION['errore'])){
                    echo $_SESSION['errore'];
                    unset($_SESSION['errore']);
                }
            ?>
        </div>
        
    </div>
</body>
</html> 