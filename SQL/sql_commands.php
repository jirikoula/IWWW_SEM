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

function deleteFromUzivatele() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();

    return $stmt;
}

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

function selectFromUzivatele() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION["edit_id"]);
    $stmt->execute();

    return $stmt;
}

function updateUzivatele() {
    $conn = connectToDatabase();

    $uzivatelske_jmeno_nove = htmlspecialchars($_POST["uzivatelske_jmeno"]);
    $email_novy = htmlspecialchars($_POST["email"]);
    $jmeno_nove = htmlspecialchars($_POST["jmeno"]);
    $prijmeni_nove = htmlspecialchars($_POST["prijmeni"]);
    $role_nova = htmlspecialchars($_POST["role"]);

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

    $userName = htmlspecialchars($_POST["uzivatelske_jmeno"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["heslo"]);
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 'registrovany';
    $stmt = $conn->prepare("INSERT INTO uzivatele (uzivatelske_jmeno, email, heslo, role) VALUES (:uzivatelske_jmeno, :email, :heslo, :role)");

    $stmt->bindParam(':uzivatelske_jmeno', $userName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':heslo', $hashPassword);
    $stmt->bindParam(':role', $role);

    $stmt->execute();
    return $stmt;
}

function insertIntoUzivateleAdmin() {
    $conn = connectToDatabase();

    $userName = htmlspecialchars($_POST["uzivatelske_jmeno"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["heslo"]);
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST["role"]);
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

function deleteFromUzivateleWhereId($id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM uzivatele WHERE id = $id");
    $stmt->execute();

    return $stmt;
}

function deleteFromProduktyWhereId($id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM kategorie_produkty WHERE id_produkt = $id");
    $stmt->execute();

    $stmt = $conn->prepare(" DELETE FROM produkty WHERE id = $id");
    $stmt->execute();

    return $stmt;
}

function deleteFromDopravaWhereId($id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM doprava WHERE id_doprava = $id");
    $stmt->execute();

    return $stmt;
}

function deleteFromFormularWhereId($id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM formular WHERE id = $id");
    $stmt->execute();

    return $stmt;
}

function deleteFromKategorieWhereId($id) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare(" DELETE FROM kategorie WHERE id = $id");
    $stmt->execute();

    return $stmt;
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

    header("Location: index.php?page=account");

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

function selectFromDopravaWhereIdEqualsId() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT nazev, cena FROM doprava WHERE id_doprava = :id");
    $stmt->bindParam(':id', $_SESSION["edit_id"]);
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

    header("Location: index.php?page=account");

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

    header("Location: index.php?page=account");

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

    header("Location: index.php?page=account");

    return $stmt;
}

function selectFromUzivateleAdmin() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT id, uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele");
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

function selectFromProduktyAdmin() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT ID, nazev, cena, rok_vydani, delka, video_odkaz FROM produkty");
    $stmt->execute();

    return $stmt;
}

function selectFromDopravaAdmin() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT id_doprava, nazev, cena FROM doprava");
    $stmt->execute();

    return $stmt;
}

function selectFromKategorieAdmin() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM kategorie");
    $stmt->execute();

    return $stmt;
}

function selectFromFormularAdmin() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM formular");
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

function readJson($nazev, $cena) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare('INSERT INTO doprava(nazev, cena) values(:nazev, :cena)');
    $stmt->bindValue('nazev', $nazev);
    $stmt->bindValue('cena', $cena);
    $stmt->execute();
    header('Location: index.php?page=account');
}

function writeJson() {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT ID, nazev, cena, delka, obrazek, rok_vydani, video_odkaz FROM produkty");
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

function insertIntoObjednavkaPolozky($id_objednavka, $id_produkt, $pocet_kusu, $cena_za_kus) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO objednavka_polozky(id_objednavka, id_produkt, pocet_kusu, cena_za_kus) VALUES (:id_objednavka, :id_produkt, :pocet_kusu, :cena_za_kus)");
    $stmt->bindParam(':id_objednavka', $id_objednavka);
    $stmt->bindParam(':id_produkt', $id_produkt);
    $stmt->bindParam(':pocet_kusu', $pocet_kusu);
    $stmt->bindParam(':cena_za_kus', $cena_za_kus);
    $stmt->execute();
}