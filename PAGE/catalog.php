<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$catalog = "";
$stmt = selectAllFromProdukty();

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
}
?>
<h2 id="h2_black">Nabídka filmů</h2>

<p>TODO: Kategorie, filtrování</p>

<section class="sekce_katalog">
    <?php
    foreach ($catalog as $item) {
        ?>
        <article class="sekce_katalog_article">
            <div>
                <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img alt="fotka filmu" src="data:image/jpeg;base64,<?php echo base64_encode($item["obrazek"]) ?>" class="katalog_obrazek"></a>
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
                <?php echo $item["popis"]; ?>
                <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
            </div>
            <a href="index.php?page=catalog&action=add&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
        </article>
        <?php
    }
    if ($_GET["action"] == "add" && !empty($_GET["id"])) {
        addToCart($_GET["id"]);
    }
    ?>
</section>
