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
                echo "<td><a href='index.php?page=tableProdukty&action=edit_produkty&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=tableProdukty&action=delete_produkty&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = Produkty::selectFromProduktyAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaProdukty(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=tableProdukty&action=create_produkty' title='Vytvořit záznam'>Vytvořit nový produkt &#x2710</a>
    <?php
    //zdroj: https://www.kodingmadesimple.com/2015/01/convert-mysql-to-json-using-php.html, editováno
    if(isset($_POST['buttonExport'])) {
        $stmt = Json::writeJson();

        $pole = array();
        while ($radek = $stmt->fetch()) {
            $pole[] = $radek;
        }

        $soubor = fopen('..\JSON\export.json', 'w');
        fwrite($soubor, json_encode($pole));
        fclose($soubor);
    }
    ?>
    <form action="index.php?page=tableProdukty" method="post">
        <div class="radek_formular">
            <input id="submit" type="submit" value="Export JSON" name="buttonExport">
        </div>
    </form>
</section>