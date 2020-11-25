<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<h2 id="h2_form">MOJE OBJEDNÁVKY</h2>

<section class="formular_sekce_admin">
    <table>
        <style>
            table {
                border: solid 1px black;
                text-align: center;
                border-collapse: collapse;
            }

            th {
                padding: 5px;
            }

            td {
                width:150px;
                border:1px solid black;
                padding: 5px;
            }
        </style>
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
        class TableRows extends RecursiveIteratorIterator {

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
                echo "<td><a href='editUser.php?id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                    "<td><a href='deleteUser.php?id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
            }
        }


        try {
            $stmt = $conn->prepare("SELECT id, uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
        echo "</table>";
        ?>
</section>

<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět na můj účet</a>
</div>