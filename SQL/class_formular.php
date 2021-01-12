<?php

class Formular {

    function insertIntoFormular() {
        $conn = connectToDatabase();

        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        $email = htmlspecialchars($_POST["email"]);
        $telefon = htmlspecialchars($_POST["telefon"]);
        $zprava = htmlspecialchars($_POST["zprava"]);
        $kategorie = htmlspecialchars($_POST["kategorie"]);

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

    function deleteFromFormularWhereId($id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare(" DELETE FROM formular WHERE id = $id");
        $stmt->execute();

        return $stmt;
    }

    function selectFromFormularAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM formular");
        $stmt->execute();

        return $stmt;
    }
}