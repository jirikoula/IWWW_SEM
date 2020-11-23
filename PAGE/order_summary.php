<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body class ="body_index_form">

<?php
include "menu.php";
?>

<div id="kosik_nadpis">
    <h2 id="h2_kosik">Rekapitulace objednávky</h2>
</div>

<section class="formular_sekce">
    <form action="index.php" method="post">
        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Návrat na hlavní stránku">
        </div>
    </form>
</section>

<?php
include "footer.php";
?>

</body>
</html>