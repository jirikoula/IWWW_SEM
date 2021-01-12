<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = Kategorie::selectFromKategorieWhereIdEqualsId();

if ($stmt->rowCount() == 1) {
    $radek = $stmt->fetch();
    $nazev = $radek["nazev"];
}

if ($_POST) {
    Kategorie::updateKategorie();
}
?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=editKategorie" method="post">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text" value="<?php echo $nazev; ?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>