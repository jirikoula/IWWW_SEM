<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<h2 id="h2_form">MOJE OBJEDNÁVKY</h2>

<section class="formular_sekce">
    <?php
    $sql = "SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"];
    $stmt = $conn->query($sql);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        ?>
        <p class="odstavec_ucet">Objednávka <?php echo $row["id"] ?></p>
        <a class="tlacitko_univerzalni_ucet" href="index.php?page=my_orders_detail&id=<?php echo $row["id"] ?>">Zobrazit</a><br>
        <?php
    }
    ?>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět na můj účet</a>
    </div>
</section>