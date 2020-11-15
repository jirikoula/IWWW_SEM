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
    <link rel="stylesheet" href="../CSS/program.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class ="body_index_form">

<?php
include "menu.php";
?>

<div id="program">
    <h2 id="h2_black">Program</h2>
    <nav>
        <ul class="program_tlacitka">
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_dnes">Pondělí</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_zitra">Úterý</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_dnes">Středa</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_zitra">Čtvrtek</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_dnes">Pátek</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_zitra">Sobota</a>
            </li>
            <li class = "program_tlacitko">
                <a href="#" id="tlacitko_dnes">Neděle</a>
            </li>
        </ul>
    </nav>
</div>
<?php
include "footer.php";
?>
</body>
</html>