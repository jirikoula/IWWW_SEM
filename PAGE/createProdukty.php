<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    Produkty::insertIntoProdukty();
    header("Location: index.php?page=tableProdukty");
}

?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=createProdukty" method="post" enctype="multipart/form-data">
        <div class="radek_formular">
            <label class="label_formular">Název: </label>
            <input name="nazev" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Cena: </label>
            <input name="cena" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Rok vydání: </label>
            <input name="rok_vydani" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Délka: (min) </label>
            <input name="delka" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Obrázek: </label>
            <input name="obrazek" type="file" id="obrazek">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Kategorie produktu: </label>
            <select id="kategorie" name="kategorie">
                <?php
                $stmt = Kategorie::selectNazevFromKategorie();
                while ($radek = $stmt->fetch()) {
                    echo "<option>" . $radek['nazev'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Popis: </label>
            <textarea name="popis">
            </textarea>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Popis dlouhý: </label>
            <textarea name="popis_dlouhy">
            </textarea>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Video odkaz: </label>
            <input name="video_odkaz" type="text">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>