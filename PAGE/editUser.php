<?php
session_start();

include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();
$validation[] = NULL;
?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body>
<?php

include "menu.php";

try {
    $stmt = selectFromUzivatele();

    if ($stmt->rowCount() == 1) {
        $radek = $stmt->fetch();
        $uzivatelske_jmeno = $radek["uzivatelske_jmeno"];
        $email = $radek["email"];
        $jmeno = $radek["jmeno"];
        $prijmeni = $radek["prijmeni"];
        $_SESSION["edit_id"] = $_GET["id"];
    }
} catch (PDOException $e) {
    echo "CHYBA";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = updateUzivatele();
    } catch (PDOException $e) {
        echo "CHYBA";
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
