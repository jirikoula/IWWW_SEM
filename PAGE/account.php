<?php
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
    <section>
        <h2 id="h2_form">PŘEHLED OBJEDNÁVEK</h2>
    </section>
    <?php
}
?>



