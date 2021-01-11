<?php
include '../SQL/sql_commands.php';
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
                echo "<td><a href='index.php?page=tableObjednavky&action=edit_objednavky&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=tableObjednavky&action=delete_objednavky&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
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