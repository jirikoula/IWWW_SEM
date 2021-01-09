<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$catalog = "";

$key = $_GET["id"];
$stmt = selectAllFromProduktyBind($key);

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
}
?>
<section class="sekce_katalog_detail">
    <?php
    foreach ($catalog as $item) {
        ?>
        <article class="sekce_katalog_detail_article">
            <div class="katalog_popis_detail_obrazek">
                <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
            </div>
            <div class="katalog_popis_detail">
                <b><?php echo $item["nazev"]; ?></b>
            </div>
            <div class="katalog_popis_detail">
                <b>Rok vydání: </b><?php echo $item["rok_vydani"]; ?>
            </div>
            <div class="katalog_popis_detail">
                <b>Délka: </b><?php echo $item["delka"]; ?> min
            </div>
            <div class="katalog_popis_detail">
                <b>Kategorie: </b>
                <?php
                $id_produkt = $item["ID"];
                $stmt = selectKategorie($id_produkt);

                while($radek = $stmt->fetch()) {
                    echo $radek["nazev"] . ' ';
                }
                ?>
            </div>
            <div class="katalog_popis_detail">
                <b>Popis produktu: </b><?php echo $item["popis_dlouhy"]; ?>
            </div>
            <div class="katalog_popis_detail">
                <h4 class="katalog_cena_detail"><?php echo $item["cena"]; ?> Kč </h4>
                <a href="index.php?page=catalog&action=add&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko_detail">Koupit</a>
            </div>
            <div class="katalog_popis_detail_video">
                <iframe width=95% height=720 src="<?php echo $item["video_odkaz"]; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </article>
        <?php
    }
    ?>
</section>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=catalog">Zpět na seznam filmů</a>
</div>