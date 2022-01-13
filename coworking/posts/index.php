<?php

// Constanten (connectie-instellingen databank)
define ('DB_HOST', 'localhost');
define ('DB_USER', 'Michiel');
define ('DB_PASS', '9G2qi?q1');
define ('DB_NAME', 'michiel_vanhimbeeck_coworking');


date_default_timezone_set('Europe/Brussels');

// Verbinding maken met de databank
try {
    $db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindingsfout: ' .  $e->getMessage();
    exit;
}

// Opvragen van alle taken uit de tabel tasks
$stmt = $db->prepare('SELECT * FROM posts ORDER BY Date DESC');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);


$bericht = isset($_POST['Bericht']) ? (string)$_POST['Bericht'] : '';
$msgBericht = '';


if (isset($_POST["Post"])) {
    session_start();
    if(isset($_SESSION["widrinksUser"]) && !empty($_SESSION["widrinksUser"]))
    {
        if(isset($bericht) && !empty($bericht))
        {
            $stmt = $db->prepare('INSERT INTO posts (UserName, Date, Message) VALUES (?, ?, ?)');
            $stmt->execute(array($_SESSION["widrinksUser"], (new DateTime())->format('Y-m-d H:i:s'), $bericht));
            $bericht = '';
            header("Location: ./");
        }
        else
        {
            $msgBericht = "U kan geen leeg bericht posten!";
        }
    }
    else
    {
        $msgBericht = "U moet eerst ingelogd zijn voor u iets kan posten!";
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
    <link rel="stylesheet" href="../Style/posts.css"/>
    <link rel="stylesheet" href="../Style/navbar.css" class="css">
    <title>Posts</title>
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
        <div id="msgContainer">
            <h2>Post een bericht!</h2>
            <form action="" method="POST">
                <textarea name="Bericht" id="Bericht" rows="10"><?php echo htmlentities($bericht); ?></textarea>
                <span class="message error"><?php echo $msgBericht; ?></span><br>
                <input type="submit" id="btnPost" name="Post" value="Post bericht">
            </form>

            <?php if (sizeof($posts) > 0) { ?>
            <ul>
                <?php foreach ($posts as $post) { ?>
                <li class="post">
                    <div class="gb-datum">
                        <div class="gb"> Door: <?php echo htmlentities($post['UserName']); ?></div>
                        <div class="datum"><?php echo (new Datetime($post['Date']))->format('d-m-Y H:i:s'); ?></div>
                    </div>
                    <div class="comment">
                        <?php echo htmlentities($post['Message']); ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo '<p>Er heeft nog niemand iets gepost.</p>' . PHP_EOL;
            }
            ?>
        </div>
    </main>
</body>
</html>