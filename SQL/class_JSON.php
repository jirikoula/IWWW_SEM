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
}