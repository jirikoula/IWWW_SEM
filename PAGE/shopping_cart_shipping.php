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
        <h2 id="h2_kosik">Košík</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik_vybrano">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Dodací údaje</h2>
    </div>

    <h3 id="h3_doprava">Zvolte způsob dopravy:</h3>
    <label class="label_radio">PPL (+79 Kč)
        <input type="radio" checked="checked" name="radio">
        <span class="doprava_radiobutton"></span>
    </label>
    <label class="label_radio">DPD (+69 Kč)
        <input type="radio" name="radio">
        <span class="doprava_radiobutton"></span>
    </label>
    <label class="label_radio">GLS (+55 Kč)
        <input type="radio" name="radio">
        <span class="doprava_radiobutton"></span>
    </label>
    <label class="label_radio">inTime (+59 Kč)
        <input type="radio" name="radio">
        <span class="doprava_radiobutton"></span>
    </label>


    <div class="radek_formular">
        <a id=odkaz_kosik href="../PAGE/shopping_cart.php">Zpět</a>
    </div>
    <div class="radek_formular">
        <a id=odkaz_kosik href="../PAGE/shopping_cart_address.php">Pokračovat</a>
    </div>
</section>
<?php
include "footer.php";
?>

</body>
</html>