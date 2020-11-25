<section class="sekce_kosik">
    <div id="kosik_nadpis">
        <h2 id="h2_kosik_vybrano">Košík</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Dodací údaje</h2>
    </div>
</section>
<section>
    <style>
        .kosik_polozka {
            display: grid;
            grid-column-gap: 3%;
            grid-auto-columns: auto;
            margin-top: 5%;
            margin-left: 10%;
            margin-right: 10%;
        }
        .kosik_obrazek {
            height: 100px;
            grid-column:1;
        }
        #h3_cena {
            font-size: 22px;
            margin-right: 10%;
            padding-left: 75%
        }
        #sloupec_2 {
            grid-column:2;
        }
        #sloupec_3 {
            grid-column:3;
        }
        #sloupec_4 {
            grid-column:4;
            text-align: center;
        }
        #sloupec_5 {
            grid-column:5;
            color:black;
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
            padding-right: 10px;
        }
        #sloupec_6 {
            grid-column:6;
        }
        #sloupec_7 {
            grid-column:7;
            color:black;
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
            padding-right: 10px;
        }
        #sloupec_8 {
            grid-column:8;
            text-align: center;
        }
        #sloupec_9 {
            grid-column:9;
            color:red;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            padding-right: 10px;
            margin-top: 75%;
        }
        .kosik_nadpis {
            font-weight: bold;
        }
    </style>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "databaze_kino";

    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $totalPrice = 0;
    if (empty($_SESSION["cart"]) == false) {
        foreach ($_SESSION["cart"] as $key => $value) {
            $catalog = array();
            $stmt = $conn->prepare(" SELECT * FROM produkty WHERE ID = :ID");

            $stmt->bindParam(':ID', $key);
            $stmt->execute();
            $catalog = $stmt->fetchAll();

            foreach ($catalog as $item) {
                $totalPrice = $totalPrice + ($value["quantity"] * $item["cena"]);
                ?>
                <div class="kosik_polozka">
                    <p></p>
                    <p class="kosik_nadpis">Název</p>
                    <p class="kosik_nadpis">Popis</p>
                    <p class="kosik_nadpis">Cena za kus</p>
                    <p></p>
                    <p class="kosik_nadpis">Počet kusů</p>
                    <p></p>
                    <p class="kosik_nadpis">Celkem</p>
                    <p></p>
                    <img class="kosik_obrazek" src="data:image/jpeg;base64,<?php echo base64_encode($item["obrazek"])?>">
                    <p id="sloupec_2"><?php echo $item["nazev"] ?></p>
                    <p id="sloupec_3"><?php echo $item["popis"] ?></p>
                    <p id="sloupec_4"><?php echo $item["cena"] ?> Kč</p>
                    <a id="sloupec_5" href="index.php?page=addToCart&id=<?php echo $item["ID"] ?>"> + </a>
                    <p id="sloupec_6"><?php echo $value["quantity"] ?> ks</p>
                    <a id="sloupec_7" href="index.php?page=removeFromCart&id=<?php echo $item["ID"] ?>"> - </a>
                    <p id="sloupec_8"><?php echo $value["quantity"] * $item["cena"] ?> Kč</p>
                    <a id="sloupec_9" href="index.php?page=deleteFromCart&id=<?php echo $item["ID"] ?>"> X </a>
                </div>

            <?php }
        }
    }
    ?>
    <div>
        <h3 id="h3_cena"> Celková cena: <?php echo $totalPrice ?> Kč</h3>
    </div>
    <?php
    if (isset($_SESSION["isLogged"]) == true) {
    ?>
    <div class="radek_formular">
        <a id=odkaz_kosik href="index.php?page=shopping_cart_shipping">Pokračovat</a>
    </div>
    <?php
    } else {
        ?>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=login">PRO POKRAČOVÁNÍ SE MUSÍTE PŘIHLÁSIT!</a>
        </div>
    <?php
    }
    ?>
</section>
