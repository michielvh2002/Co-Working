<?php
include '../classes/Dranken.class.php';

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
        $stmt = $db->prepare("SELECT * FROM dranken");
        $stmt->execute();
        $Dranken = $stmt->fetch(PDO::FETCH_ASSOC);
        $Bieren = array();
        foreach($Dranken as $key => $value) {
            $Bier = array(new Drank($value['Type'], $value['Naam'], $value['Soort'], $value['Brouwer'], $value['Info'], $value['Afbeelding'], $value['Maps'], $value['Video']));
            array_push($Bieren, $Bier);
        }
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bieren</title>
    <link rel="stylesheet" href="../Style/list.css">
</head>
<body>
<header>
    <ul class="container">
    <?php
        foreach($Bieren as $individual)
        {
            echo implode($individual);
        }
        ?>
        <li class="home">
            <a href="../"><img src="../img/Header/Home.png" alt=""></a>
            <h2>Home</h2>
        </li>

        <li class="bier">
            <a href="../bier/"><img src="../img/Header/Bierglas.png" alt="Bierglas"></a>
            <h2>Bier</h2>
        </li>

        <li class="wijn">
            <a href="../wijn"><img src="../img/Header/Wijn.png" alt="Wijn"></a>
            <h2>Wijn</h2>
        </li>

        <li class="sterke">
            <a href="../sterke-drank"><img src="../img/Header/SterkeDrank.png" alt="Sterke Drank"></a>
            <h2>Sterke drank</h2>
        </li>

        <li>
            <a href="#"><h2 class="button">Login</h2></a>
            <a href="#"><h2 class="button">Registreren</h2></a>
        </li>
    </ul>
</header>
<main>
    <h1>Bieren</h1>
    <ul class="container">
        <li>
            <img src="https://imgur.com/J7HsO0C.png" alt="Affligem">
            <a href="../bieren"><h3>Affligem Blond</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/NfBF4KI.png" alt="Cornet">
            <a href="../bieren/cornet.html"><h3>Cornet</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/tdMMnh9.png" alt="Wieze">
            <a href="../bieren/wieze.html"><h3>Wieze</h3></a>
        </li>
    </ul>
    <ul class="container">
        <li>
            <img src="https://imgur.com/vzew01Q.png" alt="Duvel">
            <a href="../bieren/duvel.html"><h3>Duvel</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/zMGfNCR.png" alt="Palm">
            <a href="../bieren/palm.html"><h3>Palm</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/nUQ94xU.png" alt="La Trappe">
            <a href="../bieren/latrappe.html"><h3>La Trappe Blond</h3></a>
        </li>
    </ul>
    <ul class="container">
        <li>
            <img src="https://imgur.com/QBgBkfj.png" alt="Witkap-Pater Tripel">
            <a href="../bieren/witkap.html"><h3>Witkap-Pater Tripel</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/F4vkPrU.png" alt="Westmalle">
            <a href="../bieren/westmalle.html"><h3>Westmalle Tripel</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/K6OJFfW.png" alt="Kwak">
            <a href="../bieren/kwak.html"><h3>Pauwel Kwak</h3></a>
        </li>
    </ul>
    <ul class="container">
        <li>
            <img src="https://imgur.com/0dwti92.png" alt="Westveleteren Blond">
            <a href="../bieren/westvleterenblond.html"><h3>Westvleteren Blond</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/BHb5yDL.png" alt="Westvleteren apt 8">
            <a href="../bieren/westvleteren6.html"><h3>Westvleteren apt 8</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/pYWqDx7.png" alt="Westvleteren apt 12">
            <a href="../bieren/westvleteren12.html"><h3>Westvleteren apt 12</h3></a>
        </li>
    </ul>
    <ul class="container">
        <li>
            <img src="https://imgur.com/6rWjfpi.png" alt="Omer">
            <a href="../bieren/omer.html"><h3>Westvleteren Blond</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/KFpI0Lb.png" alt="Brugse zot">
            <a href="../bieren/brugsezot.html"><h3>Brugse zot</h3></a>
        </li>

        <li>
            <img src="https://imgur.com/wotlox7.png" alt="Orval">
            <a href="../bieren/orval.html"><h3>Orval</h3></a>
        </li>
    </ul>
</main>
<footer>
    <p>Co-Working - groep 7 - socials - copyright</p>
</footer>
</body>
</html>