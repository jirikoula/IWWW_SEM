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
                echo "<td><a href='index.php?page=tableDoprava&action=edit_doprava&id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='index.php?page=tableDoprava&action=delete_doprava&id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" .
                    "</tr>" . "\n";
            }
        }

        try {
            $stmt = Doprava::selectFromDopravaAdmin();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TabulkaDoprava(new RecursiveArrayIterator($stmt->fetchAll())) as $k=> $v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "CHYBA: " . $e->getMessage();
        }
        ?>
    </table>
    <a href='index.php?page=tableDoprava&action=create_doprava' title='Vytvořit záznam'>Vytvořit nový typ dopravy &#x2710</a>
<?php
//zdroj: https://www.kodingmadesimple.com/2014/12/how-to-insert-json-data-into-mysql-php.html, editováno
if(isset($_POST['buttonImport'])) {
    $jsondata = file_get_contents('C:\xampp\htdocs\IWWW_SEM\JSON/'.$_FILES['jsonFile']['name']);

    $data = json_decode($jsondata, true);

    $nazev = $data["nazev"];
    $cena = $data["cena"];
    Json::readJson($nazev, $cena);
}
?>
        <form action="index.php?page=tableDoprava" method="post" enctype="multipart/form-data">
            <div class="radek_formular">
                <label class="label_formular">JSON soubor: </label>
                <input type="file" name="jsonFile">
            </div>
            <div class="radek_formular">
                <input id="submit" type="submit" value="Import JSON" name="buttonImport">
            </div>
        </form>
    </section>
