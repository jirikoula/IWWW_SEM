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
                echo "<td><a href='index.php?page=tableDotazy&action=delete_dotaz&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
            }
        }

        try {
            $stmt = Formular::selectFromFormularAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaDotazy(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
</table>
</section>