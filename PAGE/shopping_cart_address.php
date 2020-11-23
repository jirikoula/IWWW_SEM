<section class="sekce_kosik">
    <div id="kosik_nadpis">
        <h2 id="h2_kosik">Košík</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik">Doprava</h2>
        <h2 id="h2_kosik"> > </h2>
        <h2 id="h2_kosik_vybrano">Dodací údaje</h2>
    </div>
</section>

<section class="formular_sekce">
    <form action="order_summary.php" method="post">

        <div class="radek_formular">
            <label class="label_formular">Jméno: </label>
            <input name="jmeno" type="text" required value="<?php echo $_SESSION["jmeno"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Příjmení: </label>
            <input name="prijmeni" type="text" required value="<?php echo $_SESSION["prijmeni"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email" required value="<?php echo $_SESSION["email"]?>">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Tel. číslo </label>
            <input name="telefon" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Ulice: </label>
            <input name="ulice" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Číslo popisné: </label>
            <input name="c.popisne" type="text" required>
        </div>
        <div class="radek_formular">
            <label class="label_formular">Město: </label>
            <input name="mesto" type="text" required>
        </div>

        <div class="radek_formular">
            <input id=odkaz_kosik type="submit" value="Dokončit objednávku">
        </div>
        <div class="radek_formular">
            <a id=odkaz_kosik href="index.php?page=shopping_cart_shipping">Zpět</a>
        </div>
    </form>
</section>
