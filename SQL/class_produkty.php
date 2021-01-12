<?php

class Produkty {

    function getSpecificItem($item_id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT ID, obrazek, popis, cena FROM produkty WHERE ID = :ID");
        $stmt->bindParam(':ID', $item_id);
        $stmt->execute();
        $radek = $stmt->fetch();

        return $radek;
    }

    function deleteFromProduktyWhereId($id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare(" DELETE FROM kategorie_produkty WHERE id_produkt = $id");
        $stmt->execute();

        $stmt = $conn->prepare(" DELETE FROM produkty WHERE id = $id");
        $stmt->execute();

        return $stmt;
    }

    function selectAllFromProduktyWhereIdEqualsId() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM produkty WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->execute();

        return $stmt;
    }

    function updateProdukty() {
        $conn = connectToDatabase();

        $nazev = $_POST["nazev"];
        $cena = $_POST["cena"];
        $rok_vydani = $_POST["rok_vydani"];
        $delka = $_POST["delka"];
        $id_kategorie_produktu = $_POST["id_kategorie_produktu"];
        $popis = $_POST["popis"];
        $popis_dlouhy = $_POST["popis_dlouhy"];
        $video_odkaz = $_POST["video_odkaz"];

        $stmt = $conn->prepare("UPDATE produkty SET ID = :ID, nazev = :nazev, cena = :cena, rok_vydani = :rok_vydani, delka = :delka, popis = :popis, popis_dlouhy = :popis_dlouhy, video_odkaz = :video_odkaz WHERE ID = :ID");

        $stmt->bindParam(':ID', $_SESSION["edit_id"]);
        $stmt->bindParam(':nazev', $nazev);
        $stmt->bindParam(':cena', $cena);
        $stmt->bindParam(':rok_vydani', $rok_vydani);
        $stmt->bindParam(':delka', $delka);
        $stmt->bindParam(':popis', $popis);
        $stmt->bindParam(':popis_dlouhy', $popis_dlouhy);
        $stmt->bindParam(':video_odkaz', $video_odkaz);
        $stmt->execute();

        header("Location: index.php?page=tableProdukty");

        return $stmt;
    }

    function insertIntoProdukty() {
        $conn = connectToDatabase();

        $file = $_FILES['obrazek'];
        $file_name = $file['name'];
        $file_path = $file ['tmp_name'];
        move_uploaded_file ($file_path,'C:/xampp/htdocs/IWWW_SEM/IMG/'.$file_name);

        $nazev = htmlspecialchars($_POST["nazev"]);
        $cena = htmlspecialchars($_POST["cena"]);
        $rok_vydani = htmlspecialchars($_POST["rok_vydani"]);
        $delka = htmlspecialchars($_POST["delka"]);
        $popis = htmlspecialchars($_POST["popis"]);
        $popis_dlouhy = htmlspecialchars($_POST["popis_dlouhy"]);
        $video_odkaz = htmlspecialchars($_POST["video_odkaz"]);

        $stmt = $conn->prepare("INSERT INTO produkty (nazev, cena, rok_vydani, delka, obrazek, popis, popis_dlouhy, video_odkaz) 
                                    VALUES (:nazev, :cena, :rok_vydani, :delka, '$file_name', :popis, :popis_dlouhy, :video_odkaz)");

        $stmt->bindParam(':nazev', $nazev);
        $stmt->bindParam(':cena', $cena);
        $stmt->bindParam(':rok_vydani', $rok_vydani);
        $stmt->bindParam(':delka', $delka);
        $stmt->bindParam(':popis', $popis);
        $stmt->bindParam(':popis_dlouhy', $popis_dlouhy);
        $stmt->bindParam(':video_odkaz', $video_odkaz);
        $stmt->execute();

        $id_produkt = $conn->lastInsertId();
        $nazev_kategorie = $_POST["kategorie"];
        $stmt3 = $conn->prepare("SELECT id FROM kategorie WHERE nazev = :nazev_kategorie");
        $stmt3->bindParam(':nazev_kategorie', $nazev_kategorie);
        $stmt3->execute();
        $radek = $stmt3->fetch();
        $id_kategorie = $radek["id"];

        $stmt2 = $conn->prepare("INSERT INTO kategorie_produkty(id_produkt, id_kategorie) VALUES (:id_produkt, :id_kategorie)");
        $stmt2->bindParam(':id_produkt', $id_produkt);
        $stmt2->bindParam(':id_kategorie', $id_kategorie);
        $stmt2->execute();

        return $stmt;
    }

    function updatePictureProdukty() {
        $conn = connectToDatabase();

        $file = $_FILES['obrazek'];
        $file_name = $file['name'];
        $file_path = $file ['tmp_name'];
        move_uploaded_file ($file_path,'C:/xampp/htdocs/IWWW_SEM/IMG/'.$file_name);

        $stmt = $conn->prepare("UPDATE produkty SET obrazek = '$file_name' WHERE ID = :id_produkt");
        $stmt->bindParam(':id_produkt', $_SESSION["edit_id"]);
        $stmt->execute();
    }

    function selectFromProduktyAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT ID, nazev, cena, rok_vydani, delka, video_odkaz FROM produkty");
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

    function selectAllFromProduktyNejlevnejsi($rok_vydani) {
        $conn = connectToDatabase();

        if($_SESSION["filter"] != NULL) {
            if ($_SESSION["filter"] >= "2019") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY cena");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["filter"] <= "2018") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY cena");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY cena");
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY cena");
            $stmt->execute();
        }

        return $stmt;
    }

    function selectAllFromProduktyNejdrazsi($rok_vydani) {
        $conn = connectToDatabase();

        if($_SESSION["filter"] != NULL) {
            if ($_SESSION["filter"] >= "2019") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY cena DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["filter"] <= "2018") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY cena DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY cena DESC");
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY cena DESC");
            $stmt->execute();
        }

        return $stmt;
    }

    function selectAllFromProduktyNejstarsi($rok_vydani) {
        $conn = connectToDatabase();

        if($_SESSION["filter"] != NULL) {
            if ($_SESSION["filter"] >= "2019") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY id");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["filter"] <= "2018") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY id");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY id");
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY id");
            $stmt->execute();
        }

        return $stmt;
    }

    function selectAllFromProduktyNejnovejsi($rok_vydani) {
        $conn = connectToDatabase();

        if($_SESSION["filter"] != NULL) {
            if ($_SESSION["filter"] >= "2019") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY id DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["filter"] <= "2018") {
                $stmt = $conn->prepare("SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY id DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY id DESC");
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare("SELECT * FROM produkty ORDER BY id DESC");
            $stmt->execute();
        }

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

    function selectAllFromProduktyBindYear($rok_vydani) {
        $conn = connectToDatabase();

        if ($_SESSION["sort"] != NULL) {
            if ($_SESSION["sort"] == "nejlevnejsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY cena ");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejdrazsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY cena DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejnovejsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY id");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejstarsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani ORDER BY id DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani = :rok_vydani");
            $stmt->bindParam(':rok_vydani', $rok_vydani);
            $stmt->execute();
        }

        return $stmt;
    }

    function selectAllFromProduktyBindYearr($rok_vydani) {
        $conn = connectToDatabase();

        if ($_SESSION["sort"] != NULL) {
            if ($_SESSION["sort"] == "nejlevnejsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY cena");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejdrazsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY cena DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejnovejsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY id");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else if ($_SESSION["sort"] == "nejstarsi") {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani ORDER BY id DESC");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani");
                $stmt->bindParam(':rok_vydani', $rok_vydani);
                $stmt->execute();
            }
        } else {
            $stmt = $conn->prepare(" SELECT * FROM produkty WHERE rok_vydani <= :rok_vydani");
            $stmt->bindParam(':rok_vydani', $rok_vydani);
            $stmt->execute();
        }

        return $stmt;
    }
}