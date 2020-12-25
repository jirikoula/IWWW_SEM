<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();
//error_reporting(0);

$catalog = "";

//%%%%
$pagLink = "";
$query = "SELECT COUNT(*) FROM produkty";
$stmt = $conn->query($query);
$row = $stmt->fetch();
$total_records = $row[0];
$per_page_record = 4;  // Number of entries to show in a page.

$total_pages = ceil($total_records / $per_page_record);

// Look for a GET variable page if not found default is 1.
if (isset($_GET["paging"])) {
    $page  = $_GET["paging"];
}
else {
    $page=1;
}
$start_from = ($page-1) * $per_page_record;
$_SESSION["test_start"] = $start_from;
$_SESSION["test_record"] = $per_page_record;
$query = "SELECT * FROM produkty LIMIT $start_from, $per_page_record";
$stmt = $conn->query($query);

//%%%%
$rok_vydani = $_GET["filter"];

if($_GET["filter"] != NULL) {
    $_SESSION["filter"] = $_GET["filter"];
}

if($_GET["sort"] != NULL) {
    $_SESSION["sort"] = $_GET["sort"];
}

if ($_SESSION["filter"] != NULL) {
    $rok_vydani = $_SESSION["filter"];
}

if ($_GET["filter"] == "0") {
    $_SESSION["filter"] = NULL;
}

if ($_GET["sort"] == "nejlevnejsi") {
    $stmt = selectAllFromProduktyNejlevnejsi($rok_vydani);
} else if ($_GET["sort"] == "nejdrazsi") {
    $stmt = selectAllFromProduktyNejdrazsi($rok_vydani);
} else if ($_GET["sort"] == "nejstarsi") {
    $stmt = selectAllFromProduktyNejstarsi($rok_vydani);
} else if ($_GET["sort"] == "nejnovejsi") {
    $stmt = selectAllFromProduktyNejnovejsi($rok_vydani);
} else {
    $stmt = selectAllFromProdukty();
}

if ($_GET["filter"] == "2019") {
    $stmt = selectAllFromProduktyBindYear("2019");
} else if ($_GET["filter"] == "2020") {
    $stmt = selectAllFromProduktyBindYear("2020");
} else if ($_GET["filter"] == "2018"){
    $stmt = selectAllFromProduktyBindYearr("2018");
}

//if ($stmt->rowCount() >= 1) {
//    $catalog = $stmt->fetchAll();
//} else {
//    echo "NEODPOVÍDÁ ŽÁDNÉMU FILTRU!";
//}

//%%%%%%%%
if ($stmt->rowCount() >= 1) {
    $test = $stmt->fetchAll();
}
foreach ($test as $item) {
    ?>
    <article class="sekce_katalog_article">
        <div>
            <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
        </div>
        <div class="katalog_popis">
            <b><?php echo $item["nazev"]; ?></b>
        </div>
        <div class="katalog_popis">
            <b>Rok vydání: </b><?php echo $item["rok_vydani"]; ?>
        </div>
        <div class="katalog_popis">
            <b>Délka: </b><?php echo $item["delka"]; ?> min
        </div>
        <div class="katalog_popis">
            <?php echo $item["popis"]; ?>
            <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
        </div>
        <a href="index.php?page=catalog&action=add&sort=<?php $_GET["sort"] ?>&filter=&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
    </article>
    <?php
}
?>
<section class="sekce_katalog">
<?php
while ($item = $stmt->fetch()) {
    //foreach ($test as $item) {
    /*
        ?>
    <article class="sekce_katalog_article">
            <div>
                <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
            </div>
            <div class="katalog_popis">
                <b><?php echo $item["nazev"]; ?></b>
            </div>
            <div class="katalog_popis">
                <b>Rok vydání: </b><?php echo $item["rok_vydani"]; ?>
            </div>
            <div class="katalog_popis">
                <b>Délka: </b><?php echo $item["delka"]; ?> min
            </div>
            <div class="katalog_popis">
                <?php echo $item["popis"]; ?>
                <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
            </div>
            <a href="index.php?page=catalog&action=add&sort=<?php $_GET["sort"] ?>&filter=&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
    </article>
        <?php
    */
   // }
};

?>
</section>
        <?php
if($page>=2) {
    echo "<a href='index.php?page=catalog&action=add&sort=". $_SESSION["sort"]."&filter=". $_SESSION["filter"]."&id=&paging=".($page-1)."'>  Prev </a>";
}

for ($i=1; $i<=$total_pages; $i++) {
    if ($i == $page) {
        $pagLink .= "<a class = 'active' href='index.php?page=catalog&action=add&sort=". $_SESSION["sort"]."&filter=". $_SESSION["filter"]."&id=&paging="
            .$i."'>".$i." </a>";
    }
    else  {
        $pagLink .= "<a href='index.php?page=catalog&action=add&sort=". $_SESSION["sort"]."&filter=". $_SESSION["filter"]."&id=&paging=".$i."'>   
                                                ".$i." </a>";
    }
};
echo $pagLink;

if($page<$total_pages){
    echo "<a href='index.php?page=catalog&action=add&sort=". $_SESSION["sort"]."&filter=". $_SESSION["filter"]."&id=&paging=".($page+1)."'>  Next </a>";
}
//%%%%%%%%
?>
<h2 id="h3_black">Nabídka filmů</h2>
<section class="sekce_katalog_tlacitka">
<h3 class="nadpis_katalog">Řazení:</h3>
<div class="radek_formular_katalog">
    <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejlevnejsi&filter=&id=&paging=<?php echo $page?>">Od nejlevnějšího</a>
</div>
<div class="radek_formular_katalog">
    <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejdrazsi&filter=&id=">Od nejdražšího</a>
</div>
<div class="radek_formular_katalog">
    <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejnovejsi&filter=&id=">Od nejnovějšího</a>
</div>
<div class="radek_formular_katalog">
    <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=nejstarsi&filter=&id=">Od nejstaršího</a>
</div>
</section>
<section class="sekce_katalog_tlacitka">
<h3 class="nadpis_katalog">Filtrování:</h3>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=&filter=2018&id=">Rok 2018 a méně</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=&filter=2019&id=">Rok 2019</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=&filter=2020&id=">Rok 2020</a>
    </div>
    <div class="radek_formular_katalog">
        <a class="tlacitko_univerzalni_katalog" href="index.php?page=catalog&action=add&sort=&filter=0&id=">Zrušit filtr</a>
    </div>
</section>
<section class="sekce_katalog">
    <?php /*
    foreach ($catalog as $item) {
        ?>
        <article class="sekce_katalog_article">
            <div>
                <a href="index.php?page=catalog_detail&id=<?php echo $item["ID"];?>"><img src="../IMG/<?php echo $item["obrazek"] ?>" class="katalog_obrazek"></a>
            </div>
            <div class="katalog_popis">
                <b><?php echo $item["nazev"]; ?></b>
            </div>
            <div class="katalog_popis">
                <b>Rok vydání: </b><?php echo $item["rok_vydani"]; ?>
            </div>
            <div class="katalog_popis">
                <b>Délka: </b><?php echo $item["delka"]; ?> min
            </div>
            <div class="katalog_popis">
                <?php echo $item["popis"]; ?>
                <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
            </div>
            <a href="index.php?page=catalog&action=add&sort=<?php $_GET["sort"] ?>&filter=&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
        </article>
        <?php
    }
    if ($_GET["action"] == "add" && !empty($_GET["id"])) {
        addToCart($_GET["id"]);
    } */
    ?>
</section>
