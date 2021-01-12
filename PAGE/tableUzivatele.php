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
                echo "<td><a href='index.php?page=tableUzivatele&action=edit&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=tableUzivatele&action=delete&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = Uzivatele::selectFromUzivateleAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaUzivatele(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=tableUzivatele&action=create' title='Vytvořit záznam'>Vytvořit nového uživatele &#x2710</a>
</section>