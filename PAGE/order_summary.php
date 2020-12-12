<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    $stmt = insertIntoAdresa();
}

function getBy($att, $value, $array) //Shoduje se ID v košíku?
{
    foreach ($array as $key => $val) {
        if ($val[$att] == $value) {
            return $key;
        }
    }
    return null;
}

function getSpecificItem($item_id, $conn) { //Najdi, kde se shoduje ID
    $sql = "SELECT ID, obrazek, popis, cena FROM produkty WHERE ID = :ID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ID', $item_id);
    $stmt->execute();
    $radek = $stmt->fetch();

    return $radek;
}

function getItemsOfCart($conn) { //$key = id, $value = pocet,
    $i = 0;
    $pole[][] = NULL;

    foreach ($_SESSION["cart"] as $key => $value) {
        $radek = getSpecificItem($key, $conn);

        $pole[$i]["ID"] = $radek["ID"];
        $pole[$i]["obrazek"] = $radek["obrazek"];
        $pole[$i]["popis"] = $radek["popis"];
        $pole[$i]["cena"] = $radek["cena"];
        $i++;

    }
    return $pole;
}

$catalog = getItemsOfCart($conn);

if (isset($_POST["order"])) {
    $stmt = transactionCatalog();
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
    <?php
    //Vypis položek objednávky, dopravy, ceny, ...
    function selectFromAdresa() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT jmeno, prijmeni, email, telefon, ulice, cislo_popisne, mesto FROM adresa WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION["id_adresa"]);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {
            $radek = $stmt->fetch();
            $jmeno = $radek["jmeno"];
            $prijmeni = $radek["prijmeni"];
            $email = $radek["email"];
            $telefon = $radek["telefon"];
            $ulice = $radek["ulice"];
            $cislo_popisne = $radek["cislo_popisne"];
            $mesto = $radek["mesto"];
        }
        $_SESSION["jmeno"] = $jmeno;
        $_SESSION["prijmeni"] = $prijmeni;
        $_SESSION["email"] = $email;
        $_SESSION["telefon"] = $telefon;
        $_SESSION["ulice"] = $ulice;
        $_SESSION["cislo_popisne"] = $cislo_popisne;
        $_SESSION["mesto"] = $mesto;

        return $stmt;
    }
    $stmt = selectFromAdresa();

    ?>
    <h2 id="h2_form">Doručovací údaje:</h2>
    <p><b>Jméno:</b> <?php echo $_SESSION["jmeno"]; ?></p>
    <p><b>Příjmení:</b> <?php echo $_SESSION["prijmeni"]; ?></p>
    <p><b>Email:</b> <?php echo $_SESSION["email"]; ?></p>
    <p><b>Telefon:</b> <?php echo $_SESSION["telefon"]; ?></p>
    <p><b>Ulice:</b> <?php echo $_SESSION["ulice"]; ?></p>
    <p><b>Č. popisné:</b> <?php echo $_SESSION["cislo_popisne"] ?></p>
    <p><b>Město:</b> <?php echo $_SESSION["mesto"]; ?></p>

    <h2 id="h2_form">Typ dopravy:</h2>
    <p><?php echo $_SESSION["nazev_doprava"]; ?></p>

    <h2 id="h2_form">Přehled produktů:</h2>
    <p>Naleznete v "Moje objednávky"</p>

    <h2 id="h2_form">Celková cena:</h2>
    <p><?php echo $_SESSION["celkova_cena_vypis"] ?> Kč</p>

</section>
<section class="formular_sekce">
    <form action="index.php" method="post">
        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Návrat na hlavní stránku">
        </div>
    </form>
</section>
