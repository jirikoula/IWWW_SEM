<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$catalog = array();
$stmt = selectAllFromProdukty();

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
}
?>

<section class="sekce_katalog">
    <?php
    foreach ($catalog as $item) {
        ?>
        <article class="sekce_katalog_article">
            <div>
                <div>
                    <img alt="fotka filmu" src="data:image/jpeg;base64,<?php echo base64_encode($item["obrazek"]) ?>" class="katalog_obrazek">
                </div>
            </div>
            <div class="katalog_popis">
                <?php echo $item["popis"]; ?>
                <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
            </div>
            <a href="index.php?page=movies&action=add&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
        </article>
        <?php
    }
    if ($_GET["action"] == "add" && !empty($_GET["id"])) {
        addToCart($_GET["id"]);
    }
    ?>
</section>
