<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$validation[] = NULL;
$ulozeno = 0;
$chyba_ucet = 0;

$stmt = selectFromUzivatele();

if ($_POST) {
    try {
        if(empty($_POST["heslo"]) == true) {
            $stmt = $conn->prepare("UPDATE uzivatele SET jmeno = :jmeno, prijmeni = :prijmeni WHERE id = :id");
        } else {
            $stmt = $conn->prepare("UPDATE uzivatele SET jmeno = :jmeno, prijmeni = :prijmeni, heslo = :heslo WHERE id = :id");
            $param_heslo = $_POST["heslo"];
            $hashPassword = password_hash($param_heslo, PASSWORD_DEFAULT);
            $stmt->bindParam(":heslo", $hashPassword, PDO::PARAM_STR);
        }

        $param_jmeno = $_POST["jmeno"];
        $param_prijmeni = $_POST["prijmeni"];

        $stmt->bindParam(":jmeno", $param_jmeno, PDO::PARAM_STR);
        $stmt->bindParam(":prijmeni", $param_prijmeni, PDO::PARAM_STR);
        $stmt->bindValue(":id", $_SESSION["id"], PDO::PARAM_INT);

        $_SESSION["jmeno"] = $param_jmeno;
        $_SESSION["prijmeni"] = $param_prijmeni;

        $stmt->execute();
        $ulozeno = 1;
    } catch (PDOException $e) {
        $chyba_ucet = 1;
    }
}
?>
    <h2 id="h2_form">ÚPRAVA PROFILU</h2>

<section class="formular_sekce">
    <form action="index.php?page=profile_settings" method="post">
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
            <input id="submit" type="submit" value="Uložit profil">
        </div>
        <div class="radek_formular">
            <a class="tlacitko_univerzalni" href="index.php?page=account">Zpět na můj účet</a>
        </div>
    </form>
</section>

<?php
if ($ulozeno == 1) {
echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Uloženo </div>";
}

if ($chyba_ucet == 1) {
echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA </div>";
}
?>