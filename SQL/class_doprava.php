<?php

class Doprava {
    function selectFromDopravaWhereIdEqualsId() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT nazev, cena FROM doprava WHERE id_doprava = :id");
        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->execute();

        return $stmt;
    }

    function selectFromDopravaAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id_doprava, nazev, cena FROM doprava");
        $stmt->execute();

        return $stmt;
    }

    function selectAllFromDopravaWhereIdEqualsId($id_dopravy) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM doprava WHERE id_doprava = " . $id_dopravy);
        $stmt->execute();

        return $stmt;
    }

    function selectFromDoprava() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id_doprava, nazev, cena FROM doprava");
        $stmt->execute();

        return $stmt;
    }

    function deleteFromDopravaWhereId($id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare(" DELETE FROM doprava WHERE id_doprava = $id");
        $stmt->execute();

        return $stmt;
    }

    function updateDoprava() {
        $conn = connectToDatabase();

        $nazev = $_POST["nazev"];
        $cena = $_POST["cena"];

        $stmt = $conn->prepare("UPDATE doprava SET nazev = :nazev, cena = :cena WHERE id_doprava = :id");

        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->bindParam(':nazev', $nazev);
        $stmt->bindParam(':cena', $cena);

        $stmt->execute();

        header("Location: index.php?page=tableDoprava");

        return $stmt;
    }

    function insertIntoDoprava() {
        $conn = connectToDatabase();

        $nazev = $_POST["nazev"];
        $cena = $_POST["cena"];

        $stmt = $conn->prepare("INSERT INTO doprava (nazev, cena) VALUES (:nazev, :cena)");

        $stmt->bindParam(':nazev', $nazev);
        $stmt->bindParam(':cena', $cena);

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
}