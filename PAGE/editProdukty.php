<?php
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = Produkty::selectAllFromProduktyWhereIdEqualsId();

$checked = ""; //--------!!!!

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
        //insertIntoKategorie_Produkty();



            if(!empty($_POST['lang'])) {

                $lang = implode(",",$_POST['lang']);

                // Insert and Update record
                $stmt = $conn->prepare("SELECT nazev FROM kategorie");
                $stmt->execute();
                if($stmt->rowCount() == 0){
                    $stmt = $conn->prepare("SELECT id FROM kategorie WHERE nazev = :nazev_kategorie");
                    $stmt->bindParam(':nazev_kategorie', $nazev_kategorie);
                    $stmt->execute();
                    $radek = $stmt->fetch();
                    $id_kategorie = $radek["id"];

                    $stmt2 = $conn->prepare("INSERT INTO kategorie_produkty(id_produkt, id_kategorie) VALUES (:id_produkt, :id_kategorie)");
                    $stmt2->bindParam(':id_produkt', $id_produkt);
                    $stmt2->bindParam(':id_kategorie', $lang);
                    $stmt2->execute();
                }else{
                    //mysqli_query($con,"UPDATE languages SET language='".$lang."' ");
                }


            /*
        $checkbox_kategorie = $_POST['checkbox_kategorie'];

        for ($i=0; $i<sizeof ($checkbox_kategorie); $i++) {
            $id_produkt = $_SESSION["edit_id"];
            $nazev_kategorie = $checkbox_kategorie[$i];

            $stmt = $conn->prepare("SELECT id FROM kategorie WHERE nazev = :nazev_kategorie");
            $stmt->bindParam(':nazev_kategorie', $nazev_kategorie);
            $stmt->execute();
            $radek = $stmt->fetch();
            $id_kategorie = $radek["id"];

            $stmt2 = $conn->prepare("INSERT INTO kategorie_produkty(id_produkt, id_kategorie) VALUES (:id_produkt, :id_kategorie)");
            $stmt2->bindParam(':id_produkt', $id_produkt);
            $stmt2->bindParam(':id_kategorie', $id_kategorie);
            $stmt2->execute();
            */
        }
    } else if($_POST['process'] == 'delete') {
        Kategorie::deleteFromKategorie_Produkty();
    } else if($_POST['process'] == 'picture') {
        Produkty::updatePictureProdukty();
    }
}

?>
<body class ="body_index_form">
<section class="formular_sekce">
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

<section class="formular_sekce_check">
    <form action="index.php?page=editProdukty" method="post">
        <input type="hidden" name="process" value="add">
        <div class="radek_formular">
            <label class="label_formular">Volba kategorií: </label>
                <?php
                //------------
                $id_produkt = $_SESSION["edit_id"];
                $stmt = Kategorie::selectKategorie($id_produkt);

                while($radek = $stmt->fetch()) {
                    echo "<input type='checkbox' name='checkbox_kategorie[ ]' value='{$radek['nazev']}' checked>" . $radek['nazev'];
                }
                //Pokud se kategorie.id != kategorie_produkty.id WHERE id_produkt = $id_produkt
                $stmt = $conn->prepare("SELECT nazev FROM kategorie WHERE id NOT IN 
(SELECT kategorie.nazev FROM kategorie
    INNER JOIN kategorie_produkty ON kategorie.id = kategorie_produkty.id_kategorie
    INNER JOIN produkty ON kategorie_produkty.id_produkt = produkty.ID WHERE produkty.ID = :id_produkt)");
                $stmt->bindParam(':id_produkt',$id_produkt);
                $stmt->execute();
                while ($radek = $stmt->fetch()) {

                    echo "<input type='checkbox' name='checkbox_kategorie[ ]' value='{$radek['nazev']}'>" . $radek['nazev'];
                }
                //-------------
                /*$stmt = $conn->prepare("SELECT nazev FROM kategorie");
                $stmt->execute();
                while ($radek = $stmt->fetch()) {
                  //  echo "<input type='checkbox' name='checkbox_kategorie[ ]' value='{$radek['nazev']}' '$checked'>" . $radek['nazev'];
                }*/
                ?>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>

<section class="formular_sekce">
    <form action="index.php?page=editProdukty" method="post" enctype="multipart/form-data">
        <input type="hidden" name="process" value="picture">
        <div class="radek_formular">
            <label class="label_formular">Nový obrázek produktu: </label>
            <input name="obrazek" type="file" id="obrazek">
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>
</body>