<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = Produkty::selectAllFromProduktyWhereIdEqualsId();

if ($stmt->rowCount() == 1) {
    $radek = $stmt->fetch();
    $nazev = $radek["nazev"];
    $cena = $radek["cena"];
    $rok_vydani = $radek["rok_vydani"];
    $delka = $radek["delka"];
    $popis = $radek["popis"];
    $popis_dlouhy = $radek["popis_dlouhy"];
    $video_odkaz = $radek["video_odkaz"];
    $_SESSION["edit_id"];
}

if (isset($_POST['process'])) {
    if ($_POST['process'] == 'edit') {
        Produkty::updateProdukty();
    } else if($_POST['process'] == 'add') {
        Kategorie::insertIntoKategorie_Produkty();
    } else if($_POST['process'] == 'picture') {
        Produkty::updatePictureProdukty();
    }
}

?>
<body class ="body_index_form">
<section class="formular_sekce_check">
    <form action="index.php?page=editProdukty" method="post">
        <input type="hidden" name="process" value="edit">
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
<hr>
<section class="formular_sekce_check">
    <form action="index.php?page=editProdukty" method="post">
        <input type="hidden" name="process" value="add">
        <div class="radek_formular">
            <label class="label_formular_edit">Aktuální kategorie: </label>
            <label>
                <?php
                $stmt = Kategorie::selectKategorie($_SESSION["edit_id"]);
                while($radek = $stmt->fetch()) {
                    echo $radek["nazev"] . ' ';
                }
                ?>
            </label>
        </div>
        <div class="radek_formular">
            <label class="label_formular_edit">Nové kategorie: </label>
            <?php
            $stmt = Kategorie::selectNazevFromKategorie();
            while ($radek = $stmt->fetch()) {
                echo "<input type='checkbox' name='checkbox_kategorie[ ]' value='{$radek['nazev']}' >" . $radek['nazev'];
            }
            ?>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>
<hr>
<section class="formular_sekce_check">
    <form action="index.php?page=editProdukty" method="post" enctype="multipart/form-data">
        <input type="hidden" name="process" value="picture">
        <label class="label_formular_edit">Aktuální obrázek produktu: </label>
        <?php
        $stmt = Produkty::selectObrazekFromProdukty($_SESSION["edit_id"]);
        $radek = $stmt->fetch();
        ?>
        <div>
            <img src="../IMG/<?php echo $radek["obrazek"] ?>" class="katalog_obrazek">
        </div>
        <div class="radek_formular">
            <label class="label_formular_edit">Nový obrázek produktu: </label>
            <input name="obrazek" type="file" id="obrazek">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>
</body>