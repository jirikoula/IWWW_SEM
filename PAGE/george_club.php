<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>George Cinema</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
    <link rel="stylesheet" href="../CSS/stylesheet_responsive.css">
    <link rel="stylesheet" href="../CSS/form.css">
    <link rel="stylesheet" href="../CSS/menu.css">
    <link rel="stylesheet" href="../CSS/club.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class ="body_index_form">

<?php
include "menu.php";
?>

<h2 id="h2_black">George Club</h2>

<div id="club_div">
    <img id="ikony" src="../IMG/pop_corn_ikona.png" alt="Popcorn">
    <img id="ikony" src="../IMG/ticket_ikona.png" alt="Vstupenka">
    <img id="ikony" src="../IMG/klapka_ikona.png" alt="Klapka">
    <img id="ikony" src="../IMG/kamera_ikona.png" alt="Kamera">
</div>

<div id="club_div">
    <div id="club_levy">
        <h3>Jak se stát členem?</h3>
        <ul class="club_vypis">
            <li>Registrací na stránce se automaticky stáváme členem</li>
            <li>Vystavení karty na pokladně je za poplatek 250 Kč</li>
            <li>Při zaplacení na pokaldně získáváte věrnostní body</li>
        </ul>
    </div>
    <div id="club_pravy">
        <h3>Výhody členství:</h3>
        <ul class="club_vypis">
            <li>Sleva 20 Kč na vstupenku při platbě na pokladně</li>
            <li>Pravidelné slevové akce u partnerů</li>
            <li>Speciální VIP projekce</li>
            <li>Sleva na občestvení dle aktulní nabídky</li>
            <li>Nejnovější informace o filmech</li>
            <li>Happy hour 2x více bodů za představení</li>
        </ul>
    </div>
</div>
<div class="radek_formular">
    <a id=odkaz_registrace href="../PAGE/register.php">STÁT SE ČLENEM</a>
</div>
<div class="radek_formular">
    <a id=odkaz_registrace href="../PAGE/login.php">JIŽ JSEM ČLENEM</a>
</div>

<?php
include "footer.php";
?>

</body>
</html>