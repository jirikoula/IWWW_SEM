<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

try {
    $stmt = selectFromUzivatele();

    if ($stmt->rowCount() == 1) {
        $radek = $stmt->fetch();
        $uzivatelske_jmeno = $radek["uzivatelske_jmeno"];
        $email = $radek["email"];
        $jmeno = $radek["jmeno"];
        $prijmeni = $radek["prijmeni"];
        $role = $radek["role"];
        $_SESSION["edit_id"];
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
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=editUser" method="post">
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
            <label class="label_formular">Role: </label>
            <input name="role" type="text" value="<?php echo $role; ?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>

