<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();
?>

<h2 id="h2_form">DETAIL OBJEDNÁVKY</h2>

<section class="formular_sekce">
    <?php
    $celkova_cena = 0;

    if(isset($_GET["id"])) {
        $id_objednavky = $_GET["id"];

        $stmt = selectAllFromObjednavkyWhereIdEqualsId($id_objednavky);
        $radek = $stmt->fetch();
        $id_dopravy = $radek["id_doprava"];

        $stmt_nazev_dopravy = selectAllFromDopravaWhereIdEqualsId($id_dopravy);
        $radek_cena_dopravy = $stmt_nazev_dopravy->fetch();
        ?>
        <p><div class="odstavec_detail">Název dopravy: </div><?php echo $radek_cena_dopravy["nazev"];?></p>
        <p><div class="odstavec_detail">Cena dopravy: </div><?php echo $radek_cena_dopravy["cena"];?> Kč</p>
        <hr>
        <?php
        $cena_dopravy = $radek_cena_dopravy["cena"];

        $stmt_2 = selectAllFromObjednavka_polozkyWhereIdEqualsId($id_objednavky);

        while($radek = $stmt_2->fetch()) {
            $id_produkt = $radek["id_produkt"];
            $stmt_3 = selectNazevFromProduktyWhereIDEqualsId($id_produkt);
            ?>
            <p><div class="odstavec_detail">Název produktu: </div><?php echo $stmt_3["nazev"];?></p>
            <p><div class="odstavec_detail">Počet kusů: </div><?php echo $radek["pocet_kusu"];?></p>
            <p><div class="odstavec_detail">Cena za kus: </div><?php echo $radek["cena_za_kus"];?> Kč</p>
            <hr>
            <?php
            $celkova_cena = $celkova_cena + $radek["pocet_kusu"] * $radek["cena_za_kus"];
        }
    }
    $celkova_cena = $celkova_cena + $cena_dopravy;
    ?>
    <p><div class="odstavec_detail">Celková cena objednávky: </div><?php echo $celkova_cena;?> Kč</p>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=my_orders">Zpět na moje objednávky</a>
    </div>
</section>
