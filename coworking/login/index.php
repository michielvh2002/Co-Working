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
        $wachtwoord = isset($_POST['wachtwoord']) ? (string)$_POST['wachtwoord'] : '';

        $msgEmail = '';
        $msgWachtwoord = '';
        $msgFout = '';

        // form is sent: perform formchecking!
        if (isset($_POST["Login"])) {
            $allOk = true;
            // name not empty
            if (trim($email) === '') {
                $msgEmail = 'Gelieve je email of gebruikersnaam in te voeren';
                $allOk = false;
            }
            if (trim($wachtwoord) === '') {
                $msgWachtwoord = 'Gelieve je wachtwoord in te voeren';
                $allOk = false;
            }

            // end of form check. If $allOk still is true, then the form was sent in correctly
            if ($allOk) {

                $stmt = $db->prepare("SELECT Email FROM users WHERE Email = :email");
                $stmt->execute([
                    'email' => $email
                ]);
                $Email = $stmt->fetch(PDO::FETCH_ASSOC);


                if (isset($Email) && !empty($Email)){
                    $stmt = $db->prepare("SELECT Password, UserName FROM users WHERE Email = :email");
                    $stmt->execute([
                        'email' => $email
                    ]);
                    $password = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($password['Password'] === hash("sha256", $wachtwoord)) {
                        session_start();
                        // sessievariabele invullen
                        $_SESSION["user"] = $password['UserName'];
                        header("Location: ../");
                    }
                    else {
                        $msgFout = "Foute gebruikersnaam of wachtwoord!";
                    }
                }
                else
                {
                    $stmt = $db->prepare("SELECT UserName FROM users WHERE UserName = :username");
                    $stmt->execute([
                        'username' => $email
                    ]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);


                    if (isset($user) && !empty($user)){
                        $stmt = $db->prepare("SELECT Password FROM users WHERE UserName = :username");
                        $stmt->execute([
                           'username' => $email
                        ]);
                        $password = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (implode($password) === hash("sha256", $wachtwoord)) {
                            session_start();
                            // sessievariabele invullen
                            $_SESSION["widrinksUser"] = $email;
                            header("Location: ../");
                        }
                        else {
                            $msgFout = "Foute gebruikersnaam of wachtwoord!";
                        }
                    }
                    else{
                        $msgFout = "Foute gebruikersnaam of wachtwoord!";
                    }
                }
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
    <link rel="stylesheet" href="../Style/login.css" class="css">
    <link rel="stylesheet" href="../Style/navbar.css" class="css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-216209027-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-216209027-1');
</script>
    <title>Login</title>
</head>
<body>
<header>
        <div class="Hcontainer">
            <ul>
                <li class="home Hmenu">
                    <h2 class="Htext">Home</h2>
                    <a href="../" class="Himg"><img src="../img/Header/Home.png" alt=""></a>
                </li>
        
                <li class="bier Hmenu">
                    <h2 class="Htext">Bier</h2>
                    <a href="../bier/"" class="Himg"><img src="../img/Header/Bierglas.png" alt="Bierglas"></a>
                </li>
        
                <li class="wijn Hmenu">
                    <h2 class="Htext">Wijn</h2>
                    <a href="../wijn/"" class="Himg"><img src="../img/Header/Wijn.png" alt="Wijn"></a>
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
            <h1>Login</h1>
            <span class="message error"><?php echo $msgFout; ?></span>

            <label for="email">Gebruikersnaam / email</label>
            <input type="text" id="email" name="email" class="inputVeld" value="<?php echo htmlentities($email); ?>">
            <span class="message error"><?php echo $msgEmail; ?></span>

            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" id="wachtwoord" name="wachtwoord" value="<?php echo htmlentities($wachtwoord); ?>">
            <span class="message error"><?php echo $msgWachtwoord; ?></span>

            <button type="submit" id="btnLogin" name="Login">Login</button>
        </form>
    </main>
</body>
</html>