<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$catalog = array();
$stmt = $conn->prepare(" SELECT * FROM produkty");

$stmt->execute();

if ($stmt->rowCount() >= 1) {
    $catalog = $stmt->fetchAll();
}
?>
<style>
.sekce_katalog {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;

}

.sekce_katalog_article {
    width: 350px;
    margin: 1%;
    padding-bottom: 15px;
    border: 1px solid black;
    background-color: white;
}

.katalog_cena {
    padding-left: 80%;
    color: black;
}

.katalog_popis {
    color: black;
    padding-left: 5%;
    padding-top: 2%;
}

.katalog_tlacitko {
    color: black;
    margin-left: 64%;
    font-size: 100%;
    text-decoration: none;
    padding: 10px 30px;
    background-color: darkorange;
    text-align: center;
    font-family: Arial;
    font-weight: bold;
    margin-bottom: 40%;
}

.katalog_obrazek {
    height: 250px;
    margin-top: 3%;
    margin-left: 27%;
}
</style>

<section class="sekce_katalog">
<?php
foreach ($catalog as $item) {
    ?>
    <article class="sekce_katalog_article">
        <div>
            <div>
                <img alt="fotka filmu" src="data:image/jpeg;base64,<?php echo base64_encode($item["obrazek"]) ?>" class="katalog_obrazek">
            </div>
        </div>
        <div class="katalog_popis">
            <?php echo $item["popis"]; ?>
            <h4 class="katalog_cena"><?php echo $item["cena"]; ?> Kč</h4>
        </div>
        <a href="index.php?page=dvd_movies&action=add&id=<?php echo $item["ID"]; ?>" class="katalog_tlacitko">Koupit</a>
    </article>
    <?php
}
if ($_GET["action"] == "add" && !empty($_GET["id"])) {
    addToCart($_GET["id"]);

}

function addToCart($productId)
{
    if (!array_key_exists($productId, $_SESSION["cart"])) {
        $_SESSION["cart"][$productId]["quantity"] = 1;
    } else {
        $_SESSION["cart"][$productId]["quantity"]++;
    }
}
?>
</section>
