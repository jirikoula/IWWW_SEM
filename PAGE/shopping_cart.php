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

<section class="sekce_kosik">
    <div id="kosik_nadpis">
        <h2 id="h2_kosik_vybrano">Košík</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Dodací údaje</h2>
    </div>

    <div class="radek_formular">
        <a id=odkaz_kosik href="../PAGE/shopping_cart_shipping.php">Pokračovat</a>
    </div>
</section>
<?php
include "footer.php";
?>

</body>
</html>