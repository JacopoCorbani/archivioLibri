<?php 
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include 'connessione.php';
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(mysqli_connect_errno()){
            echo "connessione falita: ". die(mysqli_connect_error());
        }
        $nomeUtente = $_POST["utente"];
        $password = $_POST["password"];
        
        $query = "SELECT passwordUtente FROM utenti WHERE nomeUtente = '$nomeUtente'";
        $risultato = mysqli_query($conn, $query);
        $passwordCriptata = mysqli_fetch_assoc($risultato)['passwordUtente'];

        if(password_verify($password, $passwordCriptata)){
            $_SESSION['login'] = true;
            $_SESSION['utente'] = $risultato;
            //echo "va";
            header("Location: menu.php");
            exit;
        }else{
            $_SESSION['login'] = false;
            $_SESSION['errore'] = "Password Errata";
            header("Location: ../index.php");
            exit;
        }
        mysqli_close($conn);
    }else{
        header("Location: ../index.php");
        exit;
    }
?>