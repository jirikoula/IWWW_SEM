<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = Objednavky::selectFromObjednavkySTAV();

if ($stmt->rowCount() == 1) {
    $radek = $stmt->fetch();
    $id_stav = $radek["id_stav"];
}

if ($_POST) {
    Objednavky::updateObjednavky();
}
?>
<body class ="body_index_form">

<section class="formular_sekce">
    <?php
    $celkova_cena = 0;
    $cena_dopravy = 0;

    $id_objednavky = $_SESSION["edit_id"];

    $stmt = Objednavky::selectAllFromObjednavkyIdObjednavky($id_objednavky);
    $radek2 = $stmt->fetch();
    $id_dopravy = $radek2["id_doprava"];

    $stmt_nazev_dopravy = Doprava::selectAllFromDopravaWhereIdEqualsId($id_dopravy);
    $radek_doprava = $stmt_nazev_dopravy->fetch();

    $stmt_nazev_stavu = Objednavky::selectAllFromObjednavkyStavWhereIdEqualsId($id_stav);
    $radek_nazev_stavu = $stmt_nazev_stavu->fetch();
    ?>
    <p><div class="odstavec_detail">Stav objednávky: </div><?php echo $radek_nazev_stavu["nazev"];?></p>
    <p><div class="odstavec_detail">Název dopravy: </div><?php echo $radek_doprava["nazev"];?></p>
    <p><div class="odstavec_detail">Cena dopravy: </div><?php echo $radek_doprava["cena"];?> Kč</p>
    <hr>
    <?php
    $cena_dopravy = $radek_doprava["cena"];

    $stmt = Objednavky::selectAllFromObjednavka_polozkyWhereIdEqualsId($id_objednavky);

    while($radek = $stmt->fetch()) {
        $id_produkt = $radek["id_produkt"];
        $nazev = Produkty::selectNazevFromProduktyWhereIDEqualsId($id_produkt);
        ?>
        <p><div class="odstavec_detail">Název produktu: </div><?php echo $nazev["nazev"];?></p>
        <p><div class="odstavec_detail">Počet kusů: </div><?php echo $radek["pocet_kusu"];?></p>
        <p><div class="odstavec_detail">Cena za kus: </div><?php echo $radek["cena_za_kus"];?> Kč</p>
        <hr>
        <?php
        $celkova_cena = $celkova_cena + $radek["pocet_kusu"] * $radek["cena_za_kus"];

    }
    $celkova_cena = $celkova_cena + $cena_dopravy;
    ?>
    <p><div class="odstavec_detail">Celková cena objednávky: </div><?php echo $celkova_cena;?> Kč</p>
</section>

<section class="formular_sekce">
    <form action="index.php?page=editObjednavky" method="post">
        <div class="radek_formular">
            <label class="label_formular">Stav objednávky: </label>
            <select name="combo_stav" id="combo_stav">
                <?php
                $stmt = Objednavky::selectAllFromObjednavkyStav();
                while($radek = $stmt->fetch()){
                    echo "<option value='".$radek["id"]."'>".$radek["nazev"]."</option>";
                }
                ?>
            </select>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
        <div class="radek_formular">
            <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět</a>
        </div>
    </form>
</section>


