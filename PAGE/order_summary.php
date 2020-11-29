<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

//zdroj: stackoverflow (následující dvě funkce)
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
    $arr[][] = NULL;
    $i = 0;
    $sql = "SELECT * FROM produkty";
    $stmt = $pdo->query($sql);
    while ($row = $stmt->fetch()) {
        $arr[$i]["ID"] = $row["ID"];
        $arr[$i]["obrazek"] = $row["obrazek"];
        $arr[$i]["popis"] = $row["popis"];
        $arr[$i]["cena"] = $row["cena"];
        $i++;
    }
    return $arr;
}

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$catalog = createCatalog($conn);

if (isset($_POST["order"])) {
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
