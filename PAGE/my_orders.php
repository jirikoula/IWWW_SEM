<?php
include '../FUNCTIONS/functions.php';
?>
<h2 id="h2_form">MOJE OBJEDNÁVKY</h2>

<section class="formular_sekce">
    <?php
    $stmt = Objednavky::selectAllFromObjednavky();

    while ($radek = $stmt->fetch()) {
        ?>
        <p class="odstavec_ucet">Objednávka č. <?php echo $radek["id"] ?></p>
        <a class="tlacitko_univerzalni_ucet" href="index.php?page=my_orders_detail&id=<?php echo $radek["id"] ?>">Zobrazit</a><br>
        <?php
    }
    ?>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět na můj účet</a>
    </div>
</section>