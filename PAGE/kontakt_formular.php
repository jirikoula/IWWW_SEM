<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$formularOdeslan = 0;

if($_POST) {
    $stmt = insertIntoFormular();
    $formularOdeslan = 1;
}

?>
<section class="formular_sekce">
    <?php
    if ($formularOdeslan == 1) {
        ?>
        <div class="upozorneni"> Formulář byl úspěšné odeslán!</div>
        <?php
    }
    ?>
    <h2 id="h2_form">NAPIŠTE NÁM</h2>
    <form action="index.php?page=kontakt_formular" method="post">
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
                <option>Zařazení filmu do nabídky</option>
                <option>George Movies Club</option>
                <option>Reklamace</option>
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