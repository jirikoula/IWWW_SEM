<?php
session_start();

?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body>

<?php

include "menu.php";

$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";
$validation[] = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare(
        "SELECT uzivatelske_jmeno, email, jmeno, prijmeni FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        $uzivatelske_jmeno = $row["uzivatelske_jmeno"];
        $email = $row["email"];
        $jmeno = $row["jmeno"];
        $prijmeni = $row["prijmeni"];
        $_SESSION["edit_id"] = $_GET["id"];
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $uzivatelske_jmeno_nove = $_POST["uzivatelske_jmeno"];
        $email_novy = $_POST["email"];
        $jmeno_nove = $_POST["jmeno"];
        $prijmeni_nove = $_POST["prijmeni"];

        echo $email_novy;
        echo $uzivatelske_jmeno_nove;
        echo $jmeno_nove;
        echo $prijmeni_nove;
        echo $_SESSION["edit_id"];

        $stmt = $conn->prepare(
            "UPDATE uzivatele SET uzivatelske_jmeno = :uzivatelske_jmeno, email = :email, jmeno = :jmeno, prijmeni = :prijmeni WHERE id = :id");

        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_nove);
        $stmt->bindParam(':email', $email_novy);
        $stmt->bindParam(':jmeno', $jmeno_nove);
        $stmt->bindParam(':prijmeni', $prijmeni_nove);
        $stmt->execute();
        header("Location: account.php");
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
<section class="formular_sekce">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="radek_formular">
            <label class="label_formular">Uživ. jméno: </label>
            <input name="uzivatelske_jmeno" type="text" value="<?php echo $uzivatelske_jmeno; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email" value="<?php echo $email; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Jméno: </label>
            <input name="jmeno" type="text" value="<?php echo $jmeno; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Příjmení: </label>
            <input name="prijmeni" type="text" value="<?php echo $prijmeni; ?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>
<?php
include "footer.php";
?>
</body>
</html>
