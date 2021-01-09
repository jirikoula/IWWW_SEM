<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if (!empty($_GET["id"]) || !empty($_GET["action"])) {
    administration_manager($_GET["action"], $_GET["id"]);
}

if($_SESSION["role"] == 'registrovany') {
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
            $stmt = selectFromUzivateleAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaUzivatele(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=account&action=create' title='Vytvořit záznam'>Vytvořit nového uživatele &#x2710</a>
</section>

<section class="formular_sekce_admin">
    <h2 id="h2_form">OBJEDNÁVKY</h2>
    <table>
        <tr>
            <th>Id objednávky</th>
            <th>Jméno</th>
            <th>Přijmení</th>
            <th>Stav objednávky</th>
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

            function endChildren() {
                echo "<td><a href='index.php?page=account&action=edit_objednavky&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=account&action=delete_objednavky&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = selectFromObjednavkyAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaObjednavky(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
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

            function endChildren() {
                echo "<td><a href='index.php?page=account&action=edit_produkty&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=account&action=delete_produkty&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = selectFromProduktyAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaProdukty(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=account&action=create_produkty' title='Vytvořit záznam'>Vytvořit nový produkt &#x2710</a>
</section>
<section class="formular_sekce_admin">
    <h2 id="h2_form">DOPRAVA</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Název</th>
            <th>Cena</th>
            <th>UPDATE</th>
            <th>DELETE</th>
        </tr>
        <?php
        class TabulkaDoprava extends RecursiveIteratorIterator {

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

            function endChildren() {
                echo "<td><a href='index.php?page=account&action=edit_doprava&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=account&action=delete_doprava&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = selectFromDopravaAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaDoprava(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=account&action=create_doprava' title='Vytvořit záznam'>Vytvořit nový typ dopravy &#x2710</a>
</section>
<section class="formular_sekce_admin">
    <h2 id="h2_form">KATEGORIE PRODUKTU</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Název</th>
            <th>UPDATE</th>
            <th>DELETE</th>
        </tr>
        <?php

        class TabulkaKategorie extends RecursiveIteratorIterator {

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

            function endChildren() {
                echo "<td><a href='index.php?page=account&action=edit_kategorie&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=account&action=delete_kategorie&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
            }
        }

        try {
            $stmt = selectFromKategorieAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaKategorie(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=account&action=create_kategorie' title='Vytvořit záznam'>Vytvořit novou kategorii &#x2710</a>
</section>
<section class="formular_sekce_admin">
    <h2 id="h2_form">UŽIVATELSKÉ DOTAZY</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Jméno</th>
            <th>Přijmení</th>
            <th>Email</th>
            <th>Zpráva</th>
            <th>Telefon</th>
            <th>Kategorie</th>
            <th>DELETE</th>
        </tr>
        <?php

        class TabulkaDotazy extends RecursiveIteratorIterator {

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

            function endChildren() {
                echo "<td><a href='index.php?page=account&action=delete_dotaz&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
            }
        }

        try {
            $stmt = selectFromFormularAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaDotazy(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        }
        ?>
    </table>
</section>