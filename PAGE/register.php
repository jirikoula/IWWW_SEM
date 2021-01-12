<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$validation[] = NULL;
$pridaniOk = 0;
$jmenoPouzito = 0;
$emailPouzity = 0;

if ($_POST) {
    if (empty($_POST["uzivatelske_jmeno"])) {
        $validation["uzivatelske_jmeno"] = "Musíte vyplnit uživatelské jméno!";
    }
    if (empty($_POST["email"])) {
        $validation["email"] = "Musíte vyplnit email!";
    }
    if (empty($_POST["heslo"])) {
        $validation["heslo"] = "Musíte vyplnit heslo!";
    }

    try {
        $stmt = Uzivatele::selectIdFromUzivateleWhereName();
        $stmt2 = Uzivatele::selectIdFromUzivateleWhereEmail();

        if ($stmt->rowCount() == 1) {
            $jmenoPouzito = 1;
        } else if ($stmt2->rowCount() == 1) {
            $emailPouzity = 1;
        } else {
            if (count($validation) == 1) {
                Uzivatele::insertIntoUzivatele();
                $pridaniOk = 1;
            }
        }
    } catch (PDOException $e) {
        echo "Chyba připojení k databázi: " . $e->getMessage();
    }
}
?>
    <section class="formular_sekce">
        <form action="index.php?page=register" method="post">
            <h2 id="h2_form">REGISTRACE</h2>

            <div class="radek_formular">
                <label class="label_formular">Uživ. jméno: </label>
                <input name="uzivatelske_jmeno" type="text">
            </div>
            <div class="radek_formular">
                <label class="label_formular">Email: </label>
                <input name="email" type="email">
            </div>
            <div class="radek_formular">
                <label class="label_formular">Heslo: </label>
                <input name="heslo" type="password">
            </div>
            <div class="radek_formular">
                <input id="submit" type="submit">
            </div>
            <div class="radek_formular">
                <a class="tlacitko_univerzalni" href="index.php?page=login">Přihlásit se</a>
            </div>
        </form>
    </section>
<?php
if (count($validation) != 1) {
    if (empty($_POST["uzivatelske_jmeno"])) {
        echo "<div class='chyba'> CHYBA: Musíte vyplnit uživatelské jméno!</div>";
    }
    if (empty($_POST["email"])) {
        echo "<div class='chyba'> CHYBA: Musíte vyplnit email!</div>";
    }
    if (empty($_POST["heslo"])) {
        echo "<div class='chyba'> CHYBA: Musíte vyplnit heslo!</div>";
    }
}
if ($pridaniOk == 1) {
    echo "<div class='upozorneni'> Byl jste úspěšně zaregistrován!</div>";
}

if ($jmenoPouzito == 1) {
    echo "<div class='upozorneni'> Uživatelské jméno je již zabrané jiným uživatelem!</div>";
}

if ($emailPouzity == 1) {
    echo "<div class='upozorneni'> Email je již registrovaný pod jiným uživatelem!</div>";
}
?>