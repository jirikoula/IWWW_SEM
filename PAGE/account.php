<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_SESSION["role"] == 1) {
    ?>
    <section class="formular_sekce">
        <form action="index.php?page=account" method="post">
            <h2 id="h2_form">MŮJ ÚČET</h2>

            <div class="radek_formular">
                <a class="tlacitko_univerzalni" href="index.php?page=profile_settings">Upravit profil</a>
            </div>
            <div class="radek_formular">
                <a class="tlacitko_univerzalni" href="index.php?page=my_orders">Moje objednávky</a>
            </div>
        </form>
    </section>
    <?php
} else {
    //zdroj: w3school https://www.w3schools.com/php/php_mysql_select.asp, editováno
    ?>
    <section class="formular_sekce_admin">
        <h2 id="h2_form">UŽIVATELÉ</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Uživ. jméno</th>
                <th>Email</th>
                <th>Jmeno</th>
                <th>Příjmení</th>
                <th>Role</th>
                <th>UPDATE</th>
                <th>DELETE</th>
            </tr>
            <?php
            class TabulkaUzivatele extends RecursiveIteratorIterator {

                private $id;

                function current() {
                    return "<td contenteditable='true'>" . parent::current(). "</td>";
                }

                function beginChildren() {
                    $this->id = parent::current();
                    echo "<tr>";
                }

                function endChildren() {
                    echo "<td><a href='index.php?page=account&action=edit&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                        "<td><a href='index.php?page=account&action=delete&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                        "</tr>" . "\n";
                }
            }

            try {
                $stmt = $conn->prepare("SELECT id, uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele");
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach(new TabulkaUzivatele(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                    echo $v;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            echo "</table>";

            if (!empty($_GET["id"]) || !empty($_GET["action"])) {
                administration_manager($_GET["action"], $_GET["id"]);
            }
            ?>
            <a href='index.php?page=account&action=create' title='Vytvořit záznam'>Vytvořit nového uživatele &#x2710</a>
    </section>
    <section class="formular_sekce_admin">
        <h2 id="h2_form">OBJEDNÁVKY</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Id objednávky</th>
                <th>Id produktu</th>
                <th>Počet kusů</th>
                <th>Cena za kus</th>
                <th>UPDATE</th>
                <th>DELETE</th>
            </tr>
            <?php
            class TabulkaObjednavky extends RecursiveIteratorIterator {

                private $id;

                function __construct($it) {
                    parent::__construct($it, self::LEAVES_ONLY);
                }

                function current() {
                    return "<td contenteditable='true'>" . parent::current(). "</td>";
                }

                function beginChildren() {
                    $this->id = parent::current();
                    echo "<tr>";
                }

                function endChildren() { //TODO
                    echo "<td><a href='index.php?page=../ADMINSTRATION/editUser&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                        "<td><a href='deleteUser.php?id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
                }
            }

            try {
                $stmt = $conn->prepare("SELECT * FROM objednavka_polozky");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach(new TabulkaObjednavky(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                    echo $v;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            echo "</table>";
            ?>
    </section>
    <section class="formular_sekce_admin">
        <h2 id="h2_form">PRODUKTY</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Název</th>
                <th>Cena</th>
                <th>Rok vydání</th>
                <th>Délka (min)</th>
                <th>Video</th>
                <th>UPDATE</th>
                <th>DELETE</th>
            </tr>
            <?php
            class TabulkaProdukty extends RecursiveIteratorIterator {

                private $id;

                function __construct($it) {
                    parent::__construct($it, self::LEAVES_ONLY);
                }

                function current() {
                    return "<td contenteditable='true'>" . parent::current(). "</td>";
                }

                function beginChildren() {
                    $this->id = parent::current();
                    echo "<tr>";
                }

                function endChildren() { //TODO
                    echo "<td><a href='index.php?page=../ADMINSTRATION/editUser&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                        "<td><a href='deleteUser.php?id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
                }
            }

            try {
                $stmt = $conn->prepare("SELECT ID, nazev, cena, rok_vydani, delka, video_odkaz FROM produkty");
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach(new TabulkaProdukty(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                    echo $v;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            echo "</table>";
            ?>
    </section>
    <section class="formular_sekce_admin">
        <h2 id="h2_form">DOPRAVA</h2>
    </section>
    <section class="formular_sekce_admin">
        <h2 id="h2_form">KATEGORIE PRODUKTU</h2>
    </section>
    <?php
}
?>



