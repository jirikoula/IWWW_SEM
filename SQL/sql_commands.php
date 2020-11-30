<?php

function selectAllFromObjednavky() {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"];
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt;
}

function selectAllFromObjednavkyWhereIdEqualsId($id_objednavky) {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM objednavky WHERE id_uzivatel = " . $_SESSION["id"] . " AND id = " . $id_objednavky;
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt;
}

function selectAllFromObjednavka_polozkyWhereIdEqualsId($id_objednavky) {
    $conn = connectToDatabase();

    $sql = "SELECT * FROM objednavka_polozky WHERE id_objednavka = '$id_objednavky'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt;
}

function selectNazevFromProduktyWhereIDEqualsId($id_produkt) {
    $conn = connectToDatabase();

    $sql = "SELECT nazev FROM produkty WHERE ID = '$id_produkt'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt;
}

function selectAllFromProdukty() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" SELECT * FROM produkty");
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