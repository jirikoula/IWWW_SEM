<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$ulozeno = 0;
$chyba_ucet = 0;
$validation[] = NULL;

$sql = "SELECT uzivatelske_jmeno, email, jmeno, prijmeni FROM uzivatele WHERE id = :id";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bindValue("id", $_SESSION["id"], PDO::PARAM_INT);
    $stmt->execute();
}

if ($_POST) {
    try {
        $sql = "UPDATE uzivatele 
                SET jmeno = :jmeno, prijmeni = :prijmeni, heslo = :heslo
                WHERE id = :id";

        if ($stmt = $conn->prepare($sql)) {
            $param_heslo= $_POST["heslo"];
            $param_jmeno = $_POST["jmeno"];
            $param_prijmeni = $_POST["prijmeni"];
            $hashPassword = password_hash($param_heslo, PASSWORD_DEFAULT);

            $stmt->bindParam(":heslo", $hashPassword, PDO::PARAM_STR);
            $stmt->bindParam(":jmeno", $param_jmeno, PDO::PARAM_STR);
            $stmt->bindParam(":prijmeni", $param_prijmeni, PDO::PARAM_STR);
            $stmt->bindValue(":id", $_SESSION["id"], PDO::PARAM_INT);

            $_SESSION["jmeno"] = $param_jmeno;
            $_SESSION["prijmeni"] = $param_prijmeni;
        }
        $stmt->execute();
        $ulozeno = 1;
    } catch (PDOException $e) {
        $chyba_ucet = 1;
    }
}

if($_SESSION["role"] == 1) {
?>
<section class="formular_sekce">
    <form action="account.php" method="post">
        <h2 id="h2_form">MŮJ ÚČET</h2>

        <div class="radek_formular">
            <label class="label_formular">Uživ. jméno: </label>
            <input name="uzivatelske_jmeno" type="text" disabled="disabled" value="<?php echo $_SESSION["uzivatelske_jmeno"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email" disabled="disabled" value="<?php echo $_SESSION["email"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Nové heslo: </label>
            <input name="heslo" type="password">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Jméno: </label>
            <input name="jmeno" type="text" value="<?php echo $_SESSION["jmeno"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Příjmení: </label>
            <input name="prijmeni" type="text" value="<?php echo $_SESSION["prijmeni"]?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Upravit profil">
        </div>
    </form>
</section>
<?php
} else {
    //zdroj: w3school, editováno
?>
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

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "databaze_kino";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id, uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
            echo $v;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";

}

if ($ulozeno == 1) {
    echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Uloženo </div>";
}

if ($chyba_ucet == 1) {
    echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA </div>";
}
?>
</section>
