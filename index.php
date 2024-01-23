<?php 
    session_start();
    $_SESSION['login'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <title>Libreria</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="grid text-center">
        <div class="g-col-4"></div>
        <div class="g-col-4 contenuto">
            <div style="margin: 10px;">
                Accedi
                <form id="formpassword" method="POST" action="paginephp/controllapassword.php">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="utente" placeholder="Nome Utente">
                        <label for="floatingInput">Nome Utente</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Accedi</button>
                </form>
            </div>
            <div><a href="paginephp/menu.php" class="btn btn-primary">Continua come ospite</a></div>
            <div>
                <?php 
                    if(isset($_SESSION['errore'])){
                        echo $_SESSION['errore'];
                        unset($_SESSION['errore']);
                    }
                ?>
            </div>
        </div>
        <div class="g-col-4"></div>
    </div>
</body>
</html> 