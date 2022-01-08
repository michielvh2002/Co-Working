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
                    //, (new DateTime())->format('Y-m-d H:i:s')
                }
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registreren.css" class="css">
    <script src="registreren.js"></script>
    	<!-- Hotjar Tracking Code for https://coworking.michielvanhimbeeck.ikdoeict.be/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2768771,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
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
        <div>
           <button type="button" class="btnRegistrerheader"> <a href="../">terug</a></button> 
        
            <button type="submit" class="btnRegistrerheader">Registreer</button>
        </div>
        
    </header>
    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h1>Registreer</h1>

            <label for="fullname">Volledige naam</label>
            <input type="text" id="fullname" name="fullname" class="inputVeld" value="<?php echo htmlentities($fullname); ?>">
            <span class="message error"><?php echo $msgFullName; ?></span>

            <label for="gebruikersnaam">Gebruikersnaam</label>
            <input type="text" id="gebruikersnaam" name="gebruikersnaam" class="inputVeld" value="<?php echo htmlentities($gebruikersnaam); ?>">
            <span class="message error"><?php echo $msgGebrNaam; ?></span>

            <label for="email">Email</label>
            <input type="text" id="email" name="email" class="inputVeld" value="<?php echo htmlentities($email); ?>">
            <span class="message error"><?php echo $msgEmail; ?></span>

            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" id="wachtwoord1" name="wachtwoord1" class="inputVeld" value="<?php echo htmlentities($wachtwoord1); ?>">
            <span class="message error"><?php echo $msgWachtwoord1; ?></span>

            <label for="wachtwoord">Herhaal je wachtwoord</label>
            <input type="password" id="wachtwoord2" name="wachtwoord2" class="inputVeld" value="<?php echo htmlentities($wachtwoord2); ?>">
            <span class="message error"><?php echo $msgWachtwoord2; ?></span>


            <label for="Geboortedatum"> Geboortedatum</label>
            <div>

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
</body>
</html>