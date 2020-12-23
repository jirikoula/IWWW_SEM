<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    insertIntoAdresa();
}

$cart = getItemsOfCart();

if (isset($_POST["order"])) {
    $orderId = transactionCatalog();
    foreach ($_SESSION["cart"] as $key => $value) {
        $item = $cart[getBy("ID", $key, $cart)];
        $conn->query('INSERT INTO objednavka_polozky(id_objednavka, id_produkt, pocet_kusu, cena_za_kus) VALUES(' . $orderId . ', ' . $item["ID"] . ', ' . $value["quantity"] . ',' . $item["cena"] . ')');
    }
    unset($_SESSION["cart"]);
}

selectFromAdresa();
?>
<div id="kosik_nadpis">
    <h2 id="h2_kosik">Rekapitulace objednávky</h2>
</div>
<section class="formular_sekce">
    <h2 id="h2_form">Doručovací údaje:</h2>
    <p><b>Jméno:</b> <?php echo $_SESSION["jmeno"]; ?></p>
    <p><b>Příjmení:</b> <?php echo $_SESSION["prijmeni"]; ?></p>
    <p><b>Email:</b> <?php echo $_SESSION["email"]; ?></p>
    <p><b>Telefon:</b> <?php echo $_SESSION["telefon"]; ?></p>
    <p><b>Ulice:</b> <?php echo $_SESSION["ulice"]; ?></p>
    <p><b>Č. popisné:</b> <?php echo $_SESSION["cislo_popisne"] ?></p>
    <p><b>Město:</b> <?php echo $_SESSION["mesto"]; ?></p>

    <h2 id="h2_form">Typ dopravy:</h2>
    <p><?php echo $_SESSION["nazev_doprava"]; ?></p>

    <h2 id="h2_form">Přehled produktů:</h2>
    <p>Naleznete v "Moje objednávky"</p>

    <h2 id="h2_form">Celková cena:</h2>
    <p><?php echo $_SESSION["celkova_cena_vypis"] ?> Kč</p>

</section>
<section class="formular_sekce">
    <form action="index.php" method="post">
        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Návrat na hlavní stránku">
        </div>
    </form>
</section>