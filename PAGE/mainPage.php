<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$catalog = "";
$stmt = Produkty::selectAllFromProduktyWhereNevydano();

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
}
?>
<section id="hero">
    <h1 class="nadpis">George Movies</h1>
</section>

<div class="galerie">
    <h2 id="h2_black">Brzy v nabídce</h2>
</div>

<section>
    <div id="obrazky_galerie" class="galerie">
        <article class="obrazek_galerie">
            <?php
            foreach ($catalog as $item) {
                ?>
                <a href="index.php?page=catalog"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
                <?php
            }
            ?>
        </article>
    </div>
</section>