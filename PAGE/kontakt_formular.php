<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";
$formularOdeslan = 0;

if($_POST) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $jmeno = $_POST["jmeno"];
        $prijmeni = $_POST["prijmeni"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $zprava = $_POST["zprava"];
        $kategorie = $_POST["kategorie"];

        $stmt = $conn->prepare("INSERT INTO formular (jmeno, prijmeni, email, telefon, zprava, kategorie) VALUES (:jmeno, :prijmeni, :email, :telefon, :zprava, :kategorie)");

        $stmt->bindParam(':jmeno', $jmeno);
        $stmt->bindParam(':prijmeni', $prijmeni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefon', $telefon);
        $stmt->bindParam(':zprava', $zprava);
        $stmt->bindParam(':kategorie', $kategorie);

        $stmt->execute();

        $formularOdeslan = 1;

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
<section class="formular_sekce">
    <?php
    if ($formularOdeslan == 1) {
        echo "<div style ='font-size:20px; color:darkorange; text-align: center;'> Formulář byl úspěšné odeslán!</div>";
    }
    ?>
    <h2 id="h2_form">NAPIŠTE NÁM</h2>
    <form action="form.php" method="post">
        <div class="radek_formular">
            <label class="label_formular">Jméno: </label>
            <input name="jmeno" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Příjmení: </label>
            <input name="prijmeni" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Telefonní číslo: </label>
            <input name="telefon" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Kategorie dotazu: </label>
            <select id="kategorie" name="kategorie">
                <option>Pronájem sálu</option>
                <option>George Club</option>
                <option>Program</option>
                <option>Stížnost</option>
                <option>Jiné</option>
            </select>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Dotaz: </label>
            <textarea name="zprava" id="textarea" required></textarea>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit">
        </div>
    </form>
</section>