<?php

class Objednavky {

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

    function deleteFromObjednavkyWhereId($id) {
        $conn = connectToDatabase();
        $id_objednavky = $_SESSION["edit_id"];
        $stmt = $conn->prepare("DELETE FROM objednavka_polozky WHERE id_objednavka = $id_objednavky");
        $stmt->execute();
        $stmt = $conn->prepare(" DELETE FROM objednavky WHERE id = $id");
        $stmt->execute();

        return $stmt;
    }

    function selectFromObjednavkySTAV() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id_stav FROM objednavky WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->execute();

        return $stmt;
    }

    function updateObjednavky() {
        $conn = connectToDatabase();

        $id_stav = $_POST["combo_stav"];

        $stmt = $conn->prepare("UPDATE objednavky SET id_stav = :id_stav WHERE id = :id");

        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->bindParam(':id_stav',$id_stav);

        $stmt->execute();

        header("Location: index.php?page=tableObjednavky");

        return $stmt;
    }

    function selectAllFromObjednavkyIdObjednavky($id_objednavky) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM objednavky WHERE id = " . $id_objednavky);
        $stmt->execute();

        return $stmt;
    }

    function selectAllFromObjednavkyStav() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM objednavky_stav");
        $stmt->execute();

        return $stmt;
    }

    function selectFromObjednavkyAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT objednavky.id, adresa.jmeno, adresa.prijmeni, doprava.nazev, objednavky_stav.nazev FROM objednavky 
            INNER JOIN doprava ON objednavky.id_doprava = doprava.id_doprava
            INNER JOIN adresa ON objednavky.id_adresa = adresa.id
            INNER JOIN objednavky_stav ON objednavky.id_stav = objednavky_stav.id");
        $stmt->execute();

        return $stmt;
    }

    function insertIntoObjednavkaPolozky($id_objednavka, $id_produkt, $pocet_kusu, $cena_za_kus) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("INSERT INTO objednavka_polozky(id_objednavka, id_produkt, pocet_kusu, cena_za_kus) VALUES (:id_objednavka, :id_produkt, :pocet_kusu, :cena_za_kus)");
        $stmt->bindParam(':id_objednavka', $id_objednavka);
        $stmt->bindParam(':id_produkt', $id_produkt);
        $stmt->bindParam(':pocet_kusu', $pocet_kusu);
        $stmt->bindParam(':cena_za_kus', $cena_za_kus);
        $stmt->execute();
    }
}