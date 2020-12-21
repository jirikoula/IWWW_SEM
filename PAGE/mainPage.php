<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$catalog = "";
$stmt = selectAllFromProduktyWhereNevydano();

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
                <a href="index.php?page=catalog"><img alt="fotka filmu" src="data:image/jpeg;base64,<?php echo base64_encode($item["obrazek"]) ?>""></a>
                <?php
            }
            ?>
        </article>
    </div>
</section>