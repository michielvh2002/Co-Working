<?php
        // Show all errors (for educational purposes)
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);

        // Constanten (connectie-instellingen databank)
        define('DB_HOST', 'localhost');
        define('DB_USER', 'Michiel');
        define('DB_PASS', '9G2qi?q1');
        define('DB_NAME', 'michiel_vanhimbeeck_coworking');

        date_default_timezone_set('Europe/Brussels');

        // Verbinding maken met de databank
        try {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
           echo 'Verbindingsfout: ' . $e->getMessage();
           exit;
        }
        $email = isset($_POST['email']) ? (string)$_POST['email'] : '';
        $gebruikersnaam = isset($_POST['gebruikersnaam']) ? (string)$_POST['gebruikersnaam'] : '';
        $fullname = isset($_POST['fullname']) ? (string)$_POST['fullname'] : '';
        $wachtwoord1 = isset($_POST['wachtwoord1']) ? (string)$_POST['wachtwoord1'] : '';
        $wachtwoord2 = isset($_POST['wachtwoord2']) ? (string)$_POST['wachtwoord2'] : '';
        $gebdatDag = isset($_POST['dag']) ? (int)$_POST['dag'] : '';
        $gebdatMaand = isset($_POST['maand']) ? (int)$_POST['maand'] : '';
        $gebdatJaar = isset($_POST['jaar']) ? (int)$_POST['jaar'] : '';
        $gebdat = $gebdatJaar . "-" . $gebdatMaand . "-" . $gebdatDag;
        $vndg = date('y-m-d');

        
        $msgEmail = '';
        $msgFullName = '';
        $msgGebdat = '';
        $msgGebrNaam = '';
        $msgWachtwoord1 = '';
        $msgWachtwoord2 = '';
        $regError = '';

        // form is sent: perform formchecking!
        if (isset($_POST["Registreren"])) {
            $allOk = true;
            // name not empty
            if (trim($email) === '') {
                $msgEmail = 'Gelieve je email in te voeren';
                $allOk = false;
            }

            if (trim($gebruikersnaam) === '') {
                $msgGebrNaam = 'Gelieve een gebruikersnaam in te voeren';
                $allOk = false;
            }
            if (trim($fullname) === '') {
                $msgFullName = 'Gelieve je volledige naam in te voeren';
                $allOk = false;
            }
            if (!checkdate($gebdatMaand, $gebdatDag, $gebdatJaar)) {
                $msgGebdat = "Voer een geldige geboortedatum in!";
                $allOk = false;
            }
            else if ((date_diff(date_create($gebdat), date_create($vndg))->format('%y')) < 18) {
                $msgGebdat = 'Je bent niet oud genoeg';
                $allOk = false;
            }
            if (trim($wachtwoord1) === '') {
                $msgWachtwoord1 = 'Gelieve een wachtwoord in te voeren';
                $allOk = false;
            }
            if(trim($wachtwoord1) !== trim($wachtwoord2))
            {
                $msgWachtwoord2 = 'Uw wachtwoorden stemmen niet overeen';
                $allOk = false;
            }

            // end of form check. If $allOk still is true, then the form was sent in correctly
            if ($allOk) {

                $stmt = $db->prepare("SELECT UserName FROM users WHERE username = :username");
                $stmt->execute([
                    'username' => $gebruikersnaam
                ]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);


                if (isset($user) && !empty($user)){
                    $msgGebrNaam = 'Er bestaat al een gebruiker met deze gebruikersnaam' ;
                    $allOk = false;
                }

                $stmt = $db->prepare("SELECT Email FROM users WHERE Email = :email");
                $stmt->execute([
                    'email' => $email
                ]);
                $emailaddr = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($emailaddr) && !empty($emailaddr))
                {
                    $msgEmail = 'Er bestaat al een gebruiker met dit email adres';
                    $allOk = false;
                }
                if($allOk) {
                    $stmt = $db->prepare('INSERT INTO users (Email, Name, UserName, DateOfBirth, Password) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute(array($email,$fullname, $gebruikersnaam,$gebdat, hash("sha256",$wachtwoord1)));
                    header("Location: ../");
                }
                else
                {
                    $regError = 'Registreren mislukt!';
                }
            }
            else
            {
                $regError = 'Registreren mislukt!';
            }
        }
        unset($_POST);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/registreren.css" class="css">
    <link rel="stylesheet" href="../Style/navbar.css" class="css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-216209027-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-216209027-1');
</script>
    <title>Registreren</title>
</head>
<body onload="Start()">
<header>
        <div class="Hcontainer">
            <ul>
                <li class="home Hmenu">
                    <h2 class="Htext">Home</h2>
                    <a href="../" class="Himg"><img src="../img/Header/Home.png" alt=""></a>
                </li>
        
                <li class="bier Hmenu">
                    <h2 class="Htext">Bier</h2>
                    <a href="../bier/" class="Himg"><img src="../img/Header/Bierglas.png" alt="Bierglas"></a>
                </li>
        
                <li class="wijn Hmenu">
                    <h2 class="Htext">Wijn</h2>
                    <a href="../wijn/" class="Himg"><img src="../img/Header/Wijn.png" alt="Wijn"></a>
                </li>
        
                <li class="sterke Hmenu">
                    <h2 class="Htext">Sterke drank</h2>
                    <a href="../sterke-drank/" class="Himg"><img src="../img/Header/SterkeDrank.png" alt="Sterke Drank"></a>
                </li>
            </ul>
        </div>
    
        <div class="Hsocial">
            <a href="../login/" class="HsocialBtn"><h2>Login</h2></a>
            <a href="../registreren/" class="HsocialBtn"><h2>Registreren</h2></a>
            <a href="../posts/" class="HsocialBtn"><h2>Posts</h2></a>
        </div>
    
    
        <div class="Htaal">
            <a href="https://coworking.michielvanhimbeeck.ikdoeict.be/" class="HtaalBtn"> NL </a>
            <a href="https://coworking-michielvanhimbeeck-ikdoeict-be.translate.goog/?_x_tr_sl=nl&_x_tr_tl=fr&_x_tr_hl=nl" class="HtaalBtn"> FR </a>
            <a href="https://coworking-michielvanhimbeeck-ikdoeict-be.translate.goog/?_x_tr_sl=nl&_x_tr_tl=de&_x_tr_hl=nl" class="HtaalBtn"> DE </a>
            <a href="https://coworking-michielvanhimbeeck-ikdoeict-be.translate.goog/?_x_tr_sl=nl&_x_tr_tl=en&_x_tr_hl=nl" class="HtaalBtn"> EN </a>
        </div>
    </header>
    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h1>Registreer</h1>
            <span class="message error"><?php echo htmlentities($regError); ?></span>

            <label for="fullname">Volledige naam</label>
            <input type="text" id="fullname" name="fullname" class="inputVeld" value="<?php echo htmlentities($fullname); ?>">
            <span class="message error"><?php echo $msgFullName; ?></span>

            <label for="gebruikersnaam">Gebruikersnaam</label>
            <input type="text" id="gebruikersnaam" name="gebruikersnaam" class="inputVeld" value="<?php echo htmlentities($gebruikersnaam); ?>">
            <span class="message error"><?php echo $msgGebrNaam; ?></span>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" class="inputVeld" value="<?php echo htmlentities($email); ?>">
            <span class="message error"><?php echo $msgEmail; ?></span>

            <label for="wachtwoord1">Wachtwoord</label>
            <input type="password" id="wachtwoord1" name="wachtwoord1" class="inputVeld" value="<?php echo htmlentities($wachtwoord1); ?>">
            <span class="message error"><?php echo $msgWachtwoord1; ?></span>

            <label for="wachtwoord2">Herhaal je wachtwoord</label>
            <input type="password" id="wachtwoord2" name="wachtwoord2" class="inputVeld" value="<?php echo htmlentities($wachtwoord2); ?>">
            <span class="message error"><?php echo $msgWachtwoord2; ?></span>


            <label for="dag"> Geboortedatum</label>

            <div id="Geboortedatum">
                <div class="select">
                    <label for="dag" class="labelmeerkeus">dag</label>
                    <select name="dag" class="selectVeld" id="dag"></select>
                </div>
                <div class="select">
                    <label for="maand" class="labelmeerkeus">maand</label>
                    <select name="maand" class="selectVeld" id="maand"></select>
                </div>
                <div class="select">
                    <label for="jaar" class="labelmeerkeus">jaar</label>
                    <select name="jaar" class="selectVeld" id="jaar"></select>
                </div>
            </div>
            <span class="message error"><?php echo $msgGebdat; ?></span>

            <input type="submit" id="Registreren" name="Registreren" value="Registreer">
        </form>
    </main>
    <script src="../javascript/registreren.js"></script>
</body>
</html>