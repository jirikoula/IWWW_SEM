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

    $stmt = $conn->prepare("SELECT uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele WHERE id = :id");
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
    $role_nova = $_POST["role"];

    echo $email_novy;
    echo $uzivatelske_jmeno_nove;
    echo $jmeno_nove;
    echo $prijmeni_nove;
    echo $role_nova;
    echo $_SESSION["edit_id"];

    $stmt = $conn->prepare("UPDATE uzivatele SET uzivatelske_jmeno = :uzivatelske_jmeno, email = :email, jmeno = :jmeno, prijmeni = :prijmeni, role = :role WHERE id = :id");

    $stmt->bindParam(':id', $_SESSION["edit_id"]);
    $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_nove);
    $stmt->bindParam(':email', $email_novy);
    $stmt->bindParam(':jmeno', $jmeno_nove);
    $stmt->bindParam(':prijmeni', $prijmeni_nove);
    $stmt->bindParam(':role', $role_nova);
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
    $orderId = $conn->lastInsertId();

    return $orderId;
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

function selectAllFromUzivatele($uzivatelske_jmeno_u) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno");
    $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_u);
    $stmt->execute();

    return $stmt;
}

function selectIdFromUzivateleWhereName() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT id FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno");
    $stmt->bindParam(":uzivatelske_jmeno", $param_userName, PDO::PARAM_STR);
    $param_userName = trim($_POST["uzivatelske_jmeno"]);
    $stmt->execute();

    return $stmt;
}

function selectIdFromUzivateleWhereEmail() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT id FROM uzivatele WHERE email = :email");
    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
    $param_email = trim($_POST["email"]);
    $stmt->execute();

    return $stmt;
}

function insertIntoUzivatele() {
    $conn = connectToDatabase();

    $userName = $_POST["uzivatelske_jmeno"];
    $email = $_POST["email"];
    $password = $_POST["heslo"];
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST["role"] = 1;
    $stmt = $conn->prepare("INSERT INTO uzivatele (uzivatelske_jmeno, email, heslo, role) VALUES (:uzivatelske_jmeno, :email, :heslo, :role)");

    $stmt->bindParam(':uzivatelske_jmeno', $userName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':heslo', $hashPassword);
    $stmt->bindParam(':role', $role);

    $stmt->execute();
    return $stmt;
}

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

function getSpecificItem($item_id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT ID, obrazek, popis, cena FROM produkty WHERE ID = :ID");
    $stmt->bindParam(':ID', $item_id);
    $stmt->execute();
    $radek = $stmt->fetch();

    return $radek;
}

function getBy($id_produkt, $value, $array) { //Shoduje se ID v košíku?, PŘEDĚLAT
    foreach ($array as $key => $hodnota) {
        if ($hodnota[$id_produkt] == $value) {
            return $key;
        }
    }
}

function getItemsOfCart() { //$key = id, $value = pocet, PREDĚLAT NA PŘÍKAZ Z DATABÁZE
    $i = 0;
    $pole[][] = NULL;

    foreach ($_SESSION["cart"] as $key => $value) {
        $radek = getSpecificItem($key);

        $pole[$i]["ID"] = $radek["ID"];
        $pole[$i]["obrazek"] = $radek["obrazek"];
        $pole[$i]["popis"] = $radek["popis"];
        $pole[$i]["cena"] = $radek["cena"];
        $i++;
    }
    return $pole;
}