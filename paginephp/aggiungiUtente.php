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
    <title>Aggiungi Utente</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Aggiungi un libro
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="formUtente">
            <label for="nome">Nome</label>
            <input type="text" name="nome"><br>

            <label for="cognome">Cognome</label>
            <input type="text" name="cognome"><br>

            <label for="nomeUtente">Nome Utente</label>
            <input type="text" name="nomeUtente"><br>

            <label for="password">Password</label>
            <input type="password" name="password"><br>

            <label for="confermaPassword">Conferma password</label>
            <input type="password" name="confermaPassword"><br>
        </form>
        <button type="button" onclick="controllaForm()">Aggiungi utente</button>
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
    </div>
</body>
</html>