<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$cena_za_dopravu = 0;

$stmt = selectFromDoprava();
$radek = $stmt->fetchAll();
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
    <form action="index.php?page=shopping_cart_shipping&action=radio" method="post">
        <?php
        foreach($radek as $value) {
            ?>
            <label class="label_radio"> <?php echo $value["nazev"] ?> (+<?php echo $value["cena"] ?> Kč)
                <input type="radio" name="radio" value=<?php echo $value["id_doprava"] ?>>
                <span class="doprava_radiobutton"></span>
            </label>
            <?php
        }
        ?>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Přepočítej cenu a ulož dopravu" name="submit">
        </div>
    </form>
</section>
<?php
if (isset($_POST['submit'])) {
    if (!empty($_POST['radio'])) {
        $id_doprava = $_POST["radio"];
        $cena_za_dopravu = getPrice($id_doprava);
        $_SESSION["nazev_doprava"] = getName($id_doprava);
        $_SESSION["id_doprava"] = $id_doprava;
    }
}

?>
<section>
    <div>
        <h3 id="h3_cena"> Celková cena: <?php echo $_SESSION["celkova_cena"] + $cena_za_dopravu?> Kč</h3>
    </div>
    <div class="radek_formular">
        <a id=odkaz_kosik href="index.php?page=shopping_cart">Zpět</a>
    </div>
    <?php
    if($cena_za_dopravu <= 0) {
        echo "<div class='chyba_doprava'> Pro pokračování musíte vybrat dopravu!</div>";
    } else {
        ?>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=shopping_cart_address">Pokračovat</a>
        </div>
        <?php
    }
    $_SESSION["celkova_cena_vypis"] = $_SESSION["celkova_cena"] + $cena_za_dopravu;
    ?>
</section>