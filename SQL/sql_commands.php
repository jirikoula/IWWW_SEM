<?php

function selectAllFromObjednavky() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"]);
    $stmt->execute();

    return $stmt;
}

function selectAllFromObjednavkyWhereIdEqualsId($id_objednavky) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"] . " AND id = " . $id_objednavky);
    $stmt->execute();

    return $stmt;
}

function selectAllFromDopravaWhereIdEqualsId($id_dopravy) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM doprava WHERE id_doprava = " . $id_dopravy);
    $stmt->execute();

    return $stmt;
}

function selectAllFromObjednavkyStavWhereIdEqualsId($id_stav) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM objednavky_stav WHERE id = " . $id_stav);
    $stmt->execute();

    return $stmt;
}

function selectAllFromObjednavka_polozkyWhereIdEqualsId($id_objednavky) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM objednavka_polozky WHERE id_objednavka = '$id_objednavky'");
    $stmt->execute();

    return $stmt;
}

function selectNazevFromProduktyWhereIDEqualsId($id_produkt) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT nazev FROM produkty WHERE ID = '$id_produkt'");
    $stmt->execute();
    $nazev = $stmt->fetch();

    return $nazev;
}

function selectAllFromProdukty() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" SELECT * FROM produkty");
    $stmt->execute();

    return $stmt;
}

function selectAllFromProduktyWhereNevydano() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" SELECT * FROM produkty WHERE delka = 0");
    $stmt->execute();

    return $stmt;
}

function selectAllFromProduktyBind($key) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" SELECT * FROM produkty WHERE ID = :ID");
    $stmt->bindParam(':ID', $key);
    $stmt->execute();

    return $stmt;
}

function deleteFromUzivatele() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();

    return $stmt;
}

function insertIntoFormular() {
    $conn = connectToDatabase();

    $jmeno = $_POST["jmeno"];
    $prijmeni = $_POST["prijmeni"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $zprava = $_POST["zprava"];
    $kategorie = $_POST["kategorie"];

    $stmt = $conn->prepare("INSERT INTO formular (jmeno, prijmeni, email, telefon, zprava, kategorie) VALUES (:jmeno, :prijmeni, :email, :telefon, :zprava, :kategorie)");

    $stmt->bindParam(':jmeno', $jmeno);
    $stmt->bindParam(':prijmeni', $prijmeni);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefon', $telefon);
    $stmt->bindParam(':zprava', $zprava);
    $stmt->bindParam(':kategorie', $kategorie);

    $stmt->execute();

    return $stmt;
}

function insertIntoAdresa() {
    $conn = connectToDatabase();

    $jmeno = $_POST["jmeno"];
    $prijmeni = $_POST["prijmeni"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $ulice = $_POST["ulice"];
    $cislo_popisne = $_POST["cislo_popisne"];
    $mesto = $_POST["mesto"];

    $stmt = $conn->prepare("INSERT INTO adresa (jmeno, prijmeni, email, telefon, ulice, cislo_popisne, mesto) VALUES (:jmeno, :prijmeni, :email, :telefon, :ulice, :cislo_popisne, :mesto)");

    $stmt->bindParam(':jmeno', $jmeno);
    $stmt->bindParam(':prijmeni', $prijmeni);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefon', $telefon);
    $stmt->bindParam(':ulice', $ulice);
    $stmt->bindParam(':cislo_popisne', $cislo_popisne);
    $stmt->bindParam(':mesto', $mesto);

    $stmt->execute();

    $_SESSION["id_adresa"] = $conn->lastInsertId();

    return $stmt;
}

function selectFromUzivatele() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT uzivatelske_jmeno, email, jmeno, prijmeni FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();

    return $stmt;
}

function updateUzivatele() {
    $conn = connectToDatabase();

    $uzivatelske_jmeno_nove = $_POST["uzivatelske_jmeno"];
    $email_novy = $_POST["email"];
    $jmeno_nove = $_POST["jmeno"];
    $prijmeni_nove = $_POST["prijmeni"];

    echo $email_novy;
    echo $uzivatelske_jmeno_nove;
    echo $jmeno_nove;
    echo $prijmeni_nove;
    echo $_SESSION["edit_id"];

    $stmt = $conn->prepare("UPDATE uzivatele SET uzivatelske_jmeno = :uzivatelske_jmeno, email = :email, jmeno = :jmeno, prijmeni = :prijmeni WHERE id = :id");

    $stmt->bindParam(':id', $_SESSION["edit_id"]);
    $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_nove);
    $stmt->bindParam(':email', $email_novy);
    $stmt->bindParam(':jmeno', $jmeno_nove);
    $stmt->bindParam(':prijmeni', $prijmeni_nove);
    $stmt->execute();

    header("Location: index.php?page=account");

    return $stmt;
}

function selectFromDoprava() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT id_doprava, nazev, cena FROM doprava");
    $stmt->execute();

    return $stmt;
}

function transactionCatalog() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare('INSERT INTO objednavky(id_uzivatel, id_doprava, id_adresa) VALUES(?, ?, ?)');
    $stmt->bindParam(1, $_SESSION["id"]);
    $stmt->bindParam(2, $_SESSION["id_doprava"]);
    $stmt->bindParam(3, $_SESSION["id_adresa"]);
    $stmt->execute();
    $stmt = $conn->prepare("SELECT id FROM objednavky ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    return $stmt;
}

function getPrice($id_doprava) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT cena FROM doprava WHERE id_doprava = $id_doprava");
    $stmt->execute();
    $price = $stmt->fetch();
    $cena = $price['cena'];
    return $cena;
}

function getName($id_doprava) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT nazev FROM doprava WHERE id_doprava = $id_doprava");
    $stmt->execute();
    $name = $stmt->fetch();
    $nazev = $name['nazev'];
    return $nazev;
}