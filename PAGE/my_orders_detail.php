<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();
?>

<h2 id="h2_form">DETAIL OBJEDNÁVKY</h2>

<section class="formular_sekce">
    <?php
    if(isset($_GET["id"])) {
        $id_objednavky = $_GET["id"];

        $stmt = selectAllFromObjednavkyWhereIdEqualsId($id_objednavky);

        if($stmt->rowCount() != 1) {
            header("Location: index.php");
        }

        $stmt_2 = selectAllFromObjednavka_polozkyWhereIdEqualsId($id_objednavky);
        $celkova_cena = 0;

        while($radek = $stmt_2->fetch()) {
            $id_produkt = $radek["id_produkt"];
            $stmt_3 = selectNazevFromProduktyWhereIDEqualsId($id_produkt);
            ?>
            <p><div class="odstavec_detail">Název produktu: </div><?php echo $stmt_3->fetch()[0];?></p>
            <p><div class="odstavec_detail">Počet kusů: </div><?php echo $radek["pocet_kusu"];?></p>
            <p><div class="odstavec_detail">Cena za kus: </div><?php echo $radek["cena_za_kus"];?> Kč</p>
            <hr>
            <?php
            $celkova_cena = $celkova_cena + $radek["pocet_kusu"] * $radek["cena_za_kus"];
        }
    }
    ?>
    <p><div class="odstavec_detail">Celková cena objednávky: </div><?php echo $celkova_cena;?> Kč</p>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=my_orders">Zpět na moje objednávky</a>
    </div>
</section>
