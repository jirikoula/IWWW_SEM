<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    insertIntoDoprava();
    header("Location: index.php?page=account");
}

?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=createDoprava" method="post">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Cena: </label>
            <input name="cena" type="text" required>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>