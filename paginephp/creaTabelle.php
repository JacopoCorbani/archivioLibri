<?php
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
    <title>Crea tabelle</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div>
            <a href="menu.php">Torna alla Home</a>
        </div>
        <div>
            Crea tabelle
        </div>
    </header>
    <div id="contenuto">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
            <label for="tabella">
                <input type="radio" name="tabella" value="0">
                Crea tabella autori
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" value="1">
                Crea tabella generi
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" value="2">
                Crea tabella casa editrice
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" value="3">
                Crea tabella libri
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" value="4">
                Crea tabella autori_libri
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" id="5">
                Crea tabella nazioni
            </label><br>
            <label for="tabella">
                <input type="radio" name="tabella" id="6">
                Crea tabella utenti
            </label><br>
            <input type="submit" value="Crea">
        </form>
    </div>
    <?php 
        if(isset($_POST['tabella'])){
            switch ($_POST['tabella']) {
                case '0':
                    $query = "CREATE TABLE IF NOT EXISTS `autori` (
                        cf varchar(16) NOT NULL,
                        nome varchar(20) NOT NULL,
                        cognome varchar(20) NOT NULL,
                        nazionalità INT NOT NULL,
                        data_nascita date DEFAULT NULL,
                        PRIMARY KEY (cf),
                        FOREIGN KEY (nazionalità) REFERENCES nazioni(id)
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella Autori creata<br>";
                    break;
                case '1':
                    $query = "CREATE TABLE IF NOT EXISTS generi(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        genere VARCHAR(20) NOT NULL
                    );
                    INSERT INTO generi(genere) VALUES 
                        ('BIOGRAFIA'),
                        ('AUTOBIOGRAFIA'),
                        ('ROMANZO STORICO'),
                        ('GIALLO'),
                        ('THRILLER'),
                        ('AVVENTURA'),
                        ('AZIONE'),
                        ('DISTOPIA'),
                        ('FANTASY'),
                        ('HORROR'),
                        ('YOUNG ADULT'),
                        ('ROMANZO DI FORMAZIONE'),
                        ('ROSA'),
                        ('EROTICO'),
                        ('UMORISTICO')";
                    mysqli_query($conn, $query);
                    echo "Tabella Generi creata<br>";
                    break;
                case '2':
                    $query = "CREATE TABLE IF NOT EXISTS casa_editrice(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        nome VARCHAR(30) NOT NULL,
                        via VARCHAR(50) NOT NULL,
                        citta VARCHAR(30) NOT NULL
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella Casa editrice creata<br>";
                    break;
                case '3':
                    $query = "CREATE TABLE IF NOT EXISTS libri(
                        ISBN VARCHAR(10) PRIMARY KEY,
                        titolo VARCHAR(50) NOT NULL,
                        genere INT NOT NULL,
                        prezzo FLOAT NOT NULL CHECK(prezzo > 0),
                        anno_publicazione INT CHECK(anno_publicazione > 0),
                        id_casa_editrice INT NOT NULL,
                        
                        FOREIGN KEY (genere) REFERENCES generi(id),
                        FOREIGN KEY (id_casa_editrice) REFERENCES casa_editrice(id)
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella Libri creata<br>";
                    break;
                case '4':
                    $query = "CREATE TABLE IF NOT EXISTS autori_libri(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        ISBN_Libro VARCHAR(10) NOT NULL,
                        cf_autore VARCHAR(16) NOT NULL,
                        
                        FOREIGN KEY (ISBN_Libro) REFERENCES libri(ISBN),
                        FOREIGN KEY (cf_autore) REFERENCES autori(cf)
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella Autori creata<br>";
                    break;
                case '5':
                    $query = "CREATE TABLE IF NOT EXISTS nazioni (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        nome_nazione VARCHAR(255) NOT NULL
                    );
                    INSERT INTO nazioni (nome_nazione) VALUES
                        ('Afghanistan'),
                        ('Albania'),
                        ('Algeria'),
                        ('Andorra'),
                        ('Angola'),
                        ('Antigua e Barbuda'),
                        ('Argentina'),
                        ('Armenia'),
                        ('Australia'),
                        ('Austria'),
                        ('Azerbaigian'),
                        ('Bahamas'),
                        ('Bahrein'),
                        ('Bangladesh'),
                        ('Barbados'),
                        ('Bielorussia'),
                        ('Belgio'),
                        ('Belize'),
                        ('Benin'),
                        ('Bhutan'),
                        ('Bolivia'),
                        ('Bosnia ed Erzegovina'),
                        ('Botswana'),
                        ('Brasile'),
                        ('Brunei'),
                        ('Bulgaria'),
                        ('Burkina Faso'),
                        ('Burundi'),
                        ('Cabo Verde'),
                        ('Cambogia'),
                        ('Camerun'),
                        ('Canada'),
                        ('Ciad'),
                        ('Cile'),
                        ('Cina'),
                        ('Colombia'),
                        ('Comore'),
                        ('Congo'),
                        ('Costa d\'Avorio'),
                        ('Costa Rica'),
                        ('Croazia'),
                        ('Cuba'),
                        ('Cipro'),
                        ('Repubblica Ceca'),
                        ('Danimarca'),
                        ('Gibuti'),
                        ('Dominica'),
                        ('Repubblica Dominicana'),
                        ('Timor Est'),
                        ('Ecuador'),
                        ('Egitto'),
                        ('El Salvador'),
                        ('Guinea Equatoriale'),
                        ('Eritrea'),
                        ('Estonia'),
                        ('Etiopia'),
                        ('Figi'),
                        ('Finlandia'),
                        ('Francia'),
                        ('Gabon'),
                        ('Gambia'),
                        ('Georgia'),
                        ('Germania'),
                        ('Ghana'),
                        ('Grecia'),
                        ('Grenada'),
                        ('Guatemala'),
                        ('Guinea'),
                        ('Guinea-Bissau'),
                        ('Guyana'),
                        ('Haiti'),
                        ('Honduras'),
                        ('Ungheria'),
                        ('Islanda'),
                        ('India'),
                        ('Indonesia'),
                        ('Iran'),
                        ('Iraq'),
                        ('Irlanda'),
                        ('Israele'),
                        ('Italia'),
                        ('Giamaica'),
                        ('Giappone'),
                        ('Giordania'),
                        ('Kazakistan'),
                        ('Kenya'),
                        ('Kiribati'),
                        ('Kuwait'),
                        ('Kirghizistan'),
                        ('Laos'),
                        ('Lettonia'),
                        ('Libano'),
                        ('Lesotho'),
                        ('Liberia'),
                        ('Libia'),
                        ('Liechtenstein'),
                        ('Lituania'),
                        ('Lussemburgo'),
                        ('Macedonia del Nord'),
                        ('Madagascar'),
                        ('Malawi'),
                        ('Malaysia'),
                        ('Maldive'),
                        ('Mali'),
                        ('Malta'),
                        ('Isole Marshall'),
                        ('Mauritania'),
                        ('Mauritius'),
                        ('Messico'),
                        ('Micronesia'),
                        ('Moldova'),
                        ('Monaco'),
                        ('Mongolia'),
                        ('Montenegro'),
                        ('Marocco'),
                        ('Mozambico'),
                        ('Myanmar'),
                        ('Namibia'),
                        ('Nauru'),
                        ('Nepal'),
                        ('Paesi Bassi'),
                        ('Nuova Zelanda'),
                        ('Nicaragua'),
                        ('Niger'),
                        ('Nigeria'),
                        ('Corea del Nord'),
                        ('Norvegia'),
                        ('Oman'),
                        ('Pakistan'),
                        ('Palau'),
                        ('Panama'),
                        ('Papua Nuova Guinea'),
                        ('Paraguay'),
                        ('Perù'),
                        ('Filippine'),
                        ('Polonia'),
                        ('Portogallo'),
                        ('Qatar'),
                        ('Romania'),
                        ('Russia'),
                        ('Rwanda'),
                        ('Saint Kitts e Nevis'),
                        ('Santa Lucia'),
                        ('Saint Vincent e Grenadine'),
                        ('Samoa'),
                        ('San Marino'),
                        ('Sao Tome e Principe'),
                        ('Arabia Saudita'),
                        ('Senegal'),
                        ('Serbia'),
                        ('Seychelles'),
                        ('Sierra Leone'),
                        ('Singapore'),
                        ('Slovacchia'),
                        ('Slovenia'),
                        ('Isole Salomone'),
                        ('Somalia'),
                        ('Sud Africa'),
                        ('Corea del Sud'),
                        ('Sudan del Sud'),
                        ('Spagna'),
                        ('Sri Lanka'),
                        ('Sudan'),
                        ('Suriname'),
                        ('Svezia'),
                        ('Svizzera'),
                        ('Siria'),
                        ('Tagikistan'),
                        ('Tanzania'),
                        ('Thailandia'),
                        ('Togo'),
                        ('Tonga'),
                        ('Trinidad e Tobago'),
                        ('Tunisia'),
                        ('Turchia'),
                        ('Turkmenistan'),
                        ('Tuvalu'),
                        ('Uganda'),
                        ('Ucraina'),
                        ('Emirati Arabi Uniti'),
                        ('Regno Unito'),
                        ('Stati Uniti'),
                        ('Uruguay'),
                        ('Uzbekistan'),
                        ('Vanuatu'),
                        ('Città del Vaticano'),
                        ('Venezuela'),
                        ('Vietnam'),
                        ('Yemen'),
                        ('Zambia'),
                        ('Zimbabwe');
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella nazioni creata<br>";
                    break;
                case '6':
                    $query = "CREATE TABLE utenti(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        nome VARCHAR(20) NOT NULL,
                        cognome VARCHAR(20) NOT NULL,
                        nomeUtente VARCHAR(20) NOT NULL UNIQUE,
                        passwordUtente VARCHAR(20) NOT NULL UNIQUE
                    );";
                    mysqli_query($conn, $query);
                    echo "Tabella utenti creata<br>";
                    break;
                default:
                    echo "non va";
                    break;
            }
        }
    ?>
</body>
</html>