<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";
$hashPassword = "";
$spatne_jmeno_heslo = 0;
$prazdne_jmeno = 0;
$prazdne_heslo = 0;
$validation[] = NULL;

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_POST){
    if (empty($_POST["uzivatelske_jmeno"])) {
        $validation["uzivatelske_jmeno"] = "Musíte vyplnit uživatelské jméno!";
    }

    if (empty($_POST["heslo"])) {
        $validation["heslo"] = "Musíte vyplnit heslo!";
    }

    $sql = "SELECT role, uzivatelske_jmeno, heslo, email, jmeno, prijmeni, id FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno";

    $heslo_u = $_POST["heslo"];
    $uzivatelske_jmeno_u = $_POST["uzivatelske_jmeno"];

    if (count($validation) == 1) {
        if (empty($uzivatelske_jmeno_u) == false) {
            if (empty($heslo_u) == false) {
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_u);

                    if ($stmt->execute()) {
                        if ($stmt->rowCount() != 0) {
                            if ($radek = $stmt->fetch()) {
                                $uzivatel = $radek["uzivatelske_jmeno"];
                                $hashPassword = $radek["heslo"];
                                $email = $radek["email"];
                                $jmeno = $radek["jmeno"];
                                $prijmeni = $radek["prijmeni"];
                                $role = $radek["role"];
                                $id = $radek["id"];
                                if (password_verify($heslo_u, $hashPassword)) {
                                    $_SESSION["isLogged"] = true;
                                    $_SESSION["uzivatelske_jmeno"] = $uzivatel;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["jmeno"] = $jmeno;
                                    $_SESSION["prijmeni"] = $prijmeni;
                                    $_SESSION["role"] = $role;
                                    $_SESSION["id"] = $id;
                                    header("Location: index.php");
                                } else {
                                    $spatne_jmeno_heslo = 1;
                                }
                            }
                        }
                    }
                }
            } else {
                $prazdne_heslo = 1;
            }
        } else {
            $prazdne_jmeno = 1;
        }
    }
}
?>
<section class="formular_sekce">
<form action="index.php?page=login" method="post">
    <h2 id="h2_form">PŘIHLÁŠENÍ</h2>

    <div class="radek_formular">
        <label class="label_formular">Uživ. jméno: </label>
        <input name="uzivatelske_jmeno" type="text">
    </div>
    <div class="radek_formular">
        <label class="label_formular">Heslo: </label>
        <input name="heslo" type="password">
    </div>
    <div class="radek_formular">
        <input id="submit" type="submit">
    </div>
    <div class="radek_formular">
        <a class="tlacitko_univerzalni" href="index.php?page=register">Registrovat se</a>
    </div>
</form>
</section>
<?php
if (count($validation) != 1) {
    if (empty($_POST["uzivatelske_jmeno"])) {
        echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA: Musíte vyplnit uživatelské jméno!</div>";
    }
    if (empty($_POST["heslo"])) {
        echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA: Musíte vyplnit heslo!</div>";
    }
}

if ($spatne_jmeno_heslo == 1) {
    echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Kombinace uživatelského jména a hesla je špatná! </div>";
}
?>