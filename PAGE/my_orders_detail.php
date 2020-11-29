<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<h2 id="h2_form">DETAIL OBJEDNÁVKY</h2>

<section class="formular_sekce">
    <?php
    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"] . " AND id = " . $id;
        $stmt = $conn->query($sql);
        if($stmt->rowCount() != 1)
            header("Location: index.php");

        $sql = "SELECT * FROM objednavka_polozky WHERE id_objednavka = '$id'";
        $stmt = $conn->query($sql);
        $celkova_cena = 0;
        while($row = $stmt->fetch()) {
            $id_produkt = $row["id_produkt"];
            $sql = "SELECT nazev FROM produkty WHERE ID = '$id_produkt'";
            $stmtName = $conn->query($sql);
            ?>
            <p><div class="odstavec_detail">Název produktu: </div><?php echo $stmtName->fetch()[0];?></p>
            <p><div class="odstavec_detail">Počet kusů: </div><?php echo $row["pocet_kusu"];?></p>
            <p><div class="odstavec_detail">Cena za kus: </div><?php echo $row["cena_za_kus"];?> Kč</p>
            <p>_____________________</p>
            <?php
            $celkova_cena += $row["pocet_kusu"] * $row["cena_za_kus"];
        }
    }
    ?>
    <p><div class="odstavec_detail">Celková cena objednávky: </div><?php echo $celkova_cena;?> Kč</p>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=my_orders">Zpět na moje objednávky</a>
    </div>
</section>
