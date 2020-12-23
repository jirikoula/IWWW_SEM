<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = selectAllFromProduktyWhereIdEqualsId();

if ($stmt->rowCount() == 1) {
    $radek = $stmt->fetch();
    $nazev = $radek["nazev"];
    $cena = $radek["cena"];
    $rok_vydani = $radek["rok_vydani"];
    $delka = $radek["delka"];
    $id_kategorie_produktu = $radek["id_kategorie_produktu"];
    $popis = $radek["popis"];
    $popis_dlouhy = $radek["popis_dlouhy"];
    $video_odkaz = $radek["video_odkaz"];
    $_SESSION["edit_id"];
}

if ($_POST) {
    $stmt = updateProdukty();
}

?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=editProdukty" method="post">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text" value="<?php echo $nazev; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Cena: </label>
            <input name="cena" type="text" value="<?php echo $cena; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Rok vydání: </label>
            <input name="rok_vydani" type="text" value="<?php echo $rok_vydani; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Délka: (min) </label>
            <input name="delka" type="text" value="<?php echo $delka; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Kategorie produktu: </label>
            <input name="id_kategorie_produktu" type="text" value="<?php echo $id_kategorie_produktu; ?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Popis: </label>
            <textarea name="popis">
                <?php echo $popis ?>
            </textarea>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Popis dlouhý: </label>
            <textarea name="popis_dlouhy">
                <?php echo $popis_dlouhy ?>
            </textarea>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Video odkaz: </label>
            <input name="video_odkaz" type="text" value="<?php echo $video_odkaz; ?>">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>