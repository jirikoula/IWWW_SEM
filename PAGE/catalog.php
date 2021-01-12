<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$_SESSION["filter"] = NULL;
$catalog = "";

$rok_vydani = $_GET["filter"];

if($_GET["filter"] != NULL) {
    $_SESSION["filter"] = $_GET["filter"];
}

if($_GET["sort"] != NULL) {
    $_SESSION["sort"] = $_GET["sort"];
}

if ($_SESSION["filter"] != NULL) {
    $rok_vydani = $_SESSION["filter"];
}

if ($_GET["filter"] == "0") {
    $_SESSION["filter"] = NULL;
}

if ($_GET["sort"] == "nejlevnejsi") {
    $stmt = Produkty::selectAllFromProduktyNejlevnejsi($rok_vydani);
} else if ($_GET["sort"] == "nejdrazsi") {
    $stmt = Produkty::selectAllFromProduktyNejdrazsi($rok_vydani);
} else if ($_GET["sort"] == "nejstarsi") {
    $stmt = Produkty::selectAllFromProduktyNejstarsi($rok_vydani);
} else if ($_GET["sort"] == "nejnovejsi") {
    $stmt = Produkty::selectAllFromProduktyNejnovejsi($rok_vydani);
} else {
    $stmt = Produkty::selectAllFromProdukty();
}

if ($_GET["filter"] == "2018"){
    $stmt = Produkty::selectAllFromProduktyBindYearAndLess("2018");
} else if ($_GET["filter"] == "2019") {
    $stmt = Produkty::selectAllFromProduktyBindYear("2019");
} else if ($_GET["filter"] == "2020") {
    $stmt = Produkty::selectAllFromProduktyBindYear("2020");
}

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
} else {
    echo "NEODPOVÍDÁ ŽÁDNÉMU FILTRU!";
}
?>
<h2 id="h3_black">Nabídka filmů</h2>
<section class="sekce_katalog_tlacitka">
    <h3 class="nadpis_katalog">Řazení:</h3>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejlevnejsi&filter=<?php echo $_GET["filter"]?>&id=">Od nejlevnějšího</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejdrazsi&filter=<?php echo $_GET["filter"]?>&id=">Od nejdražšího</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejnovejsi&filter=<?php echo $_GET["filter"]?>&id=">Od nejnovějšího</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejstarsi&filter=<?php echo $_GET["filter"]?>&id=">Od nejstaršího</a>
    </div>
</section>
<section class="sekce_katalog_tlacitka">
    <h3 class="nadpis_katalog">Filtrování:</h3>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=<?php echo $_SESSION["sort"]?>&filter=2018&id=">Rok 2018 a méně</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=<?php echo $_SESSION["sort"]?>&filter=2019&id=">Rok 2019</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=<?php echo $_SESSION["sort"]?>&filter=2020&id=">Rok 2020</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=<?php echo $_SESSION["sort"]?>&filter=0&id=">Zrušit filtr</a>
    </div>
</section>
<section class="sekce_katalog">
    <?php
    foreach ($catalog as $item) {
        ?>
        <article class="sekce_katalog_article">
            <div>
                <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
            </div>
            <div class="katalog_popis">
                <b><?php echo $item["nazev"]; ?></b>
            </div>
            <div class="katalog_popis">
                <b>Rok vydání: </b><?php echo $item["rok_vydani"]; ?>
            </div>
            <div class="katalog_popis">
                <b>Délka: </b><?php echo $item["delka"]; ?> min
            </div>
            <div class="katalog_popis">
                <b>Kategorie: </b>
                <?php
                $id_produkt = $item["ID"];
                $stmt = Kategorie::selectKategorie($id_produkt);

                while($radek = $stmt->fetch()) {
                    echo $radek["nazev"] . ' ';
                }
                ?>
            </div>
            <div class="katalog_popis">
                <?php echo $item["popis"]; ?>
                <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
            </div>
            <a href="index.php?page=catalog&action=add&sort=&filter=&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
        </article>
        <?php
    }
    if ($_GET["action"] == "add" && !empty($_GET["id"])) {
        addToCart($_GET["id"]);
        header('Location: index.php?page=shopping_cart');
    }
    ?>
</section>