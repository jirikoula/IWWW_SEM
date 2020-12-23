<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$_SESSION["celkova_cena"] = 0;

?>
<section class="sekce_kosik">
    <div id="kosik_nadpis">
        <h2 id="h2_kosik_vybrano">Košík</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Dodací údaje</h2>
    </div>
</section>
<section>
    <?php
    if (!empty($_GET["id"])) {
        cart_manager($_GET["action"], $_GET["id"]);
    }

    if (empty($_SESSION["cart"]) == false) {
        foreach ($_SESSION["cart"] as $key => $value) { //Pro každou položku v košíku -->
            $stmt = selectAllFromProduktyBind($key);
            $catalog = $stmt->fetch();
            $_SESSION["celkova_cena"] = $_SESSION["celkova_cena"] + ($value["quantity"] * $catalog["cena"]);
            ?>
            <div class="kosik_polozka">
                <p></p>
                <p class="kosik_nadpis">Název</p>
                <p class="kosik_nadpis">Popis</p>
                <p class="kosik_nadpis">Cena za kus</p>
                <p></p>
                <p class="kosik_nadpis">Počet kusů</p>
                <p></p>
                <p class="kosik_nadpis">Celkem</p>
                <p></p>
                <img class="kosik_obrazek" src="../IMG/<?php echo $catalog["obrazek"] ?>" class="katalog_obrazek">
                <p id="sloupec_2"><?php echo $catalog["nazev"] ?></p>
                <p id="sloupec_3"><?php echo $catalog["popis"] ?></p>
                <p id="sloupec_4"><?php echo $catalog["cena"] ?> Kč</p>
                <a id="sloupec_5" href="index.php?page=shopping_cart&action=add&id=<?php echo $catalog["ID"];?>"> + </a>
                <p id="sloupec_6"><?php echo $value["quantity"] ?> ks</p>
                <a id="sloupec_7" href="index.php?page=shopping_cart&action=remove&id=<?php echo $catalog["ID"];  ?>"> - </a>
                <p id="sloupec_8"><?php echo $value["quantity"] * $catalog["cena"] ?> Kč</p>
                <a id="sloupec_9" href="index.php?page=shopping_cart&action=delete&id=<?php echo $catalog["ID"]; ?>"> X </a>
            </div>
        <?php }
    }
    ?>
    <div>
        <h3 id="h3_cena"> Celková cena: <?php echo $_SESSION["celkova_cena"] ?> Kč</h3>
    </div>
    <?php
    if (isset($_SESSION["isLogged"]) == true && $_SESSION["celkova_cena"] != 0) {
        ?>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=shopping_cart_shipping">Pokračovat</a>
        </div>
        <?php
    } else if ($_SESSION["celkova_cena"] == 0) {
        ?>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=catalog">KOŠÍK JE PRÁZDNÝ</a>
        </div>
        <?php
    } else {
        ?>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=login">PRO POKRAČOVÁNÍ SE MUSÍTE PŘIHLÁSIT!</a>
        </div>
        <?php
    }
    ?>
</section>
