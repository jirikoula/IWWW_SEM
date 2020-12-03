<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

//Nasledujici kod jsem nepsal - bude predelany
function getBy($att, $value, $array)
{
    foreach ($array as $key => $val) {
        if ($val[$att] == $value) {
            return $key;
        }
    }
    return null;
}

function createCatalog($pdo)
{
    $pole[][] = NULL;
    $i = 0;
    $sql = "SELECT * FROM produkty";
    $stmt = $pdo->query($sql);
    while ($radek = $stmt->fetch()) {
        $pole[$i]["ID"] = $radek["ID"];
        $pole[$i]["obrazek"] = $radek["obrazek"];
        $pole[$i]["popis"] = $radek["popis"];
        $pole[$i]["cena"] = $radek["cena"];
        $i++;
    }
    return $pole;
}

$catalog = createCatalog($conn);

if (isset($_POST["order"])) {
    //Lze to mít v transakci
    $sql = 'INSERT INTO objednavky(id_uzivatel) VALUES(' . $_SESSION["id"] . ')';
    $conn->query($sql);
    $sql = "SELECT id FROM objednavky ORDER BY id DESC LIMIT 1";
    $stmt = $conn->query($sql);
    $orderId = $stmt->fetch()[0];
    foreach ($_SESSION["cart"] as $key => $value) {
        $item = $catalog[getBy("ID", $key, $catalog)];
        $sql = 'INSERT INTO objednavka_polozky(id_objednavka, id_produkt, pocet_kusu, cena_za_kus) VALUES(' . $orderId . ', ' . $item["ID"] . ', ' . $value["quantity"] . ',' . $item["cena"] . ')';
        $conn->query($sql);
    }
    unset($_SESSION["cart"]);
}
?>
<div id="kosik_nadpis">
    <h2 id="h2_kosik">Rekapitulace objednávky</h2>
</div>

<section class="formular_sekce">
    <form action="index.php" method="post">
        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Návrat na hlavní stránku">
        </div>
    </form>
</section>
