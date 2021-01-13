<?php

class Json {

    function readJson($nazev, $cena) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare('INSERT INTO doprava(nazev, cena) values(:nazev, :cena)');
        $stmt->bindValue('nazev', $nazev);
        $stmt->bindValue('cena', $cena);
        $stmt->execute();
        header('Location: index.php?page=tableDoprava');
    }

    function writeJson() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT ID, nazev, cena, delka, obrazek, rok_vydani, video_odkaz FROM produkty");
        $stmt->execute();

        return $stmt;
    }
}