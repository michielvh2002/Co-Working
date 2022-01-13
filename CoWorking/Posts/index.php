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
    <title>Document</title>
</head>
<body>
<header>
    <ul class="container">
        <li class="home">
            <a href="../"><img src="../img/Header/Home.png" alt=""></a>
            <h2>Home</h2>
        </li>

        <li class="bier">
            <a href="../bier/"><img src="../img/Header/Bierglas.png" alt="Bierglas"></a>
            <h2>Bier</h2>
        </li>

        <li class="wijn">
            <a href="../wijn/"><img src="../img/Header/Wijn.png" alt="Wijn"></a>
            <h2>Wijn</h2>
        </li>

        <li class="sterke">
            <a href="../sterke-drank/"><img src="../img/Header/SterkeDrank.png" alt="Sterke Drank"></a>
            <h2>Sterke drank</h2>
        </li>

        <li>
            <a href="../Login/"><h2 class="button">Login</h2></a>
            <a href="../Registreren/"><h2 class="button">Registreren</h2></a>
        </li>
    </ul>
</header>
    <main>
        <div id="msgContainer">
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