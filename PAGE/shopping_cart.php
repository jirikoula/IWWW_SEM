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
    <?php
    include '../FUNCTIONS/functions.php';
    $conn = connectToDatabase();

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
