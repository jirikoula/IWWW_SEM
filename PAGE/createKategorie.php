<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    Kategorie::insertIntoKategorie();
    header("Location: index.php?page=tableKategorie");
}
?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=createKategorie" method="post">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>