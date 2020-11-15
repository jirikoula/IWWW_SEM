<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";
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
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":uzivatelske_jmeno", $param_userName, PDO::PARAM_STR);
            $param_userName = trim($_POST["uzivatelske_jmeno"]);
        }

        $sql2 = "SELECT id FROM uzivatele WHERE email = :email";

        if ($stmt2 = $conn->prepare($sql2)) {
            $stmt2->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
        }

        $stmt->execute();
        $stmt2->execute();
    } catch (PDOException $e) {
        echo "Chyba připojení k databází: " . $e->getMessage();
    }

    if ($stmt->rowCount() == 1) {
        $jmenoPouzito = 1;
    } else if ($stmt2->rowCount() == 1) {
        $emailPouzity = 1;
    } else {
        if (count($validation) == 1) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $userName = $_POST["uzivatelske_jmeno"];
                $email = $_POST["email"];
                $password = $_POST["heslo"];
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $role = $_POST["role"] = 1;
                $stmt = $conn->prepare("INSERT INTO uzivatele (uzivatelske_jmeno, email, heslo, role) VALUES (:uzivatelske_jmeno, :email, :heslo, :role)");

                $stmt->bindParam(':uzivatelske_jmeno', $userName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':heslo', $hashPassword);
                $stmt->bindParam(':role', $role);

                $stmt->execute();
                $pridaniOk = 1;
            } catch (PDOException $e) {
                echo "Chyba připojení k databází: " . $e->getMessage();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>George Cinema</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
    <link rel="stylesheet" href="../CSS/stylesheet_responsive.css">
    <link rel="stylesheet" href="../CSS/form.css">
    <link rel="stylesheet" href="../CSS/menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="body_index_form">
<?php
include "menu.php";
?>
<section class="formular_sekce">
    <form action="register.php" method="post">
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
            <a id=odkaz_registrace href="../PAGE/login.php">Přihlásit se</a>
        </div>
    </form>
</section>
<?php
if (count($validation) != 1) {
    if (empty($_POST["uzivatelske_jmeno"])) {
        echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA: Musíte vyplnit uživatelské jméno!</div>";
    }
    if (empty($_POST["email"])) {
        echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA: Musíte vyplnit email!</div>";
    }
    if (empty($_POST["heslo"])) {
        echo "<div style ='font-size:20px; color:red; text-align: center;'> CHYBA: Musíte vyplnit heslo!</div>";
    }
}
if ($pridaniOk == 1) {
    echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Byl jste úspěšně zaregistrován!</div>";
}

if ($jmenoPouzito == 1) {
    echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Uživatelské jméno je již zabrané jiným uživatelem!</div>";
}

if ($emailPouzity == 1) {
    echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Email je již registrovaný pod jiným uživatelem!</div>";
}
?>
</body>
</html>