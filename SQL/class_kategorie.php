<?php

class Kategorie {

    function selectFromKategorieAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM kategorie");
        $stmt->execute();

        return $stmt;
    }

    function selectKategorie($id_produkt) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT kategorie.nazev FROM kategorie
    INNER JOIN kategorie_produkty ON kategorie.id = kategorie_produkty.id_kategorie
    INNER JOIN produkty ON kategorie_produkty.id_produkt = produkty.ID WHERE produkty.ID = :id_produkt");
        $stmt->bindParam(':id_produkt',$id_produkt);
        $stmt->execute();

        return $stmt;
    }

    function selectNazevFromKategorie() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT nazev FROM kategorie");
        $stmt->execute();

        return $stmt;
    }

    function deleteFromKategorieWhereId($id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare(" DELETE FROM kategorie WHERE id = $id");
        $stmt->execute();

        return $stmt;
    }

    function insertIntoKategorie() {
        $conn = connectToDatabase();

        $nazev = $_POST["nazev"];

        $stmt = $conn->prepare("INSERT INTO kategorie (nazev) VALUES (:nazev)");

        $stmt->bindParam(':nazev', $nazev);

        $stmt->execute();
        return $stmt;
    }

    function selectFromKategorieWhereIdEqualsId() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT nazev FROM kategorie WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->execute();

        return $stmt;
    }

    function updateKategorie() {
        $conn = connectToDatabase();

        $nazev = $_POST["nazev"];

        $stmt = $conn->prepare("UPDATE kategorie SET nazev = :nazev WHERE id = :id");

        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->bindParam(':nazev', $nazev);

        $stmt->execute();

        header("Location: index.php?page=tableKategorie");

        return $stmt;
    }

    function deleteFromKategorie_Produkty() {
        $conn = connectToDatabase();

        $nazev_kategorie = $_POST["kategorie_delete"];

        $stmt = $conn->prepare("SELECT id FROM kategorie WHERE nazev = :nazev_kategorie");
        $stmt->bindParam(':nazev_kategorie', $nazev_kategorie);
        $stmt->execute();
        $radek = $stmt->fetch();
        $id_kategorie = $radek["id"];

        $stmt = $conn->prepare("DELETE FROM kategorie_produkty WHERE id_kategorie = :id_kategorie");
        $stmt->bindParam(':id_kategorie', $id_kategorie);
        $stmt->execute();

        return $stmt;
    }

    function editProdukty() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id_kategorie FROM kategorie_produkty WHERE id_produkt = ". $_SESSION["edit_id"]);
        $stmt->execute();
        $radek = $stmt->fetch();

        $id_kategorie = $radek["id_kategorie"];
        $stmt = $conn->prepare("SELECT nazev FROM kategorie WHERE id = ". $id_kategorie);
        $stmt->execute();

        return $stmt;
    }

    function insertIntoKategorie_Produkty() {
        $conn = connectToDatabase();

        $id_produkt = $_SESSION["edit_id"];
        $nazev_kategorie = $_POST["kategorie"];

        $stmt = $conn->prepare("SELECT id FROM kategorie WHERE nazev = :nazev_kategorie");
        $stmt->bindParam(':nazev_kategorie', $nazev_kategorie);
        $stmt->execute();
        $radek = $stmt->fetch();
        $id_kategorie = $radek["id"];

        $stmt2 = $conn->prepare("INSERT INTO kategorie_produkty(id_produkt, id_kategorie) VALUES (:id_produkt, :id_kategorie)");
        $stmt2->bindParam(':id_produkt', $id_produkt);
        $stmt2->bindParam(':id_kategorie', $id_kategorie);
        $stmt2->execute();

        return $stmt;
    }

}