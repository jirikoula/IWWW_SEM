<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = selectFromDopravaWhereIdEqualsId();

if ($stmt->rowCount() == 1) {
    $radek = $stmt->fetch();
    $nazev = $radek["nazev"];
    $cena = $radek["cena"];
}

if ($_POST) {
    updateDoprava();
}
?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=editDoprava" method="post">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text" value="<?php echo $nazev; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Cena: </label>
            <input name="cena" type="text" value="<?php echo $cena; ?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>