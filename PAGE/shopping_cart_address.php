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
        <h2 id="h2_kosik">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik_vybrano">Dodací údaje</h2>
    </div>
</section>

<section class="formular_sekce">
    <form action="index.php" method="post">

        <div class="radek_formular">
            <label class="label_formular">Jméno: </label>
            <input name="jmeno" type="text" value="<?php echo $_SESSION["jmeno"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Příjmení: </label>
            <input name="prijmeni" type="text" value="<?php echo $_SESSION["prijmeni"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email" value="<?php echo $_SESSION["email"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Tel. číslo </label>
            <input name="telefon" type="text">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Ulice: </label>
            <input name="ulice" type="text">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Číslo popisné: </label>
            <input name="c.popisne" type="text">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Město: </label>
            <input name="mesto" type="text">
        </div>

        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Dokončit objednávku">
        </div>
        <div class="radek_formular">
            <a id=odkaz_kosik href="../PAGE/shopping_cart_shipping.php">Zpět</a>
        </div>
    </form>
</section>
<?php
include "footer.php";
?>

</body>
</html>