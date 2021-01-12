<?php

class Adresa {
    function insertIntoAdresa() {
        $conn = connectToDatabase();

        $jmeno = htmlspecialchars($_POST["jmeno"]);
        $prijmeni = htmlspecialchars($_POST["prijmeni"]);
        $email = htmlspecialchars($_POST["email"]);
        $telefon = htmlspecialchars($_POST["telefon"]);
        $ulice = htmlspecialchars($_POST["ulice"]);
        $cislo_popisne = htmlspecialchars($_POST["cislo_popisne"]);
        $mesto = htmlspecialchars($_POST["mesto"]);

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
}