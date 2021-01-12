<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if (!empty($_GET["id"]) || !empty($_GET["action"])) {
    administration_manager($_GET["action"], $_GET["id"]);
}

?>
<section class="formular_sekce_admin">
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět</a>
    </div>
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
                echo "<td><a href='index.php?page=tableKategorie&action=edit_kategorie&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=tableKategorie&action=delete_kategorie&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
            }
        }

        try {
            $stmt = Kategorie::selectFromKategorieAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaKategorie(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=tableKategorie&action=create_kategorie' title='Vytvořit záznam'>Vytvořit novou kategorii &#x2710</a>
</section>