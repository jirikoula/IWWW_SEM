<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';

if($_SESSION["role"] == 'registrovany') {
    ?>
    <section class="formular_sekce">
        <form action="index.php?page=account" method="post">
            <h2 id="h2_form">MŮJ ÚČET</h2>

            <div class="radek_formular">
                <a class="tlacitko_univerzalni" href="index.php?page=profile_settings">Upravit profil</a>
            </div>
            <div class="radek_formular">
                <a class="tlacitko_univerzalni" href="index.php?page=my_orders">Moje objednávky</a>
            </div>
        </form>
    </section>
    <?php
} else {
//zdroj: w3school https://www.w3schools.com/php/php_mysql_select.asp, editováno
?>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableUzivatele">Správa uživatelů</a>
</div>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableObjednavky">Správa objednávek</a>
</div>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableProdukty">Správa produktů</a>
</div>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableDoprava">Správa dopravy</a>
</div>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableKategorie">Správa kategorií</a>
</div>
<div class="radek_formular">
    <a class="tlacitko_univerzalni" href="index.php?page=tableDotazy">Správa uživatelských dotazů</a>
</div>
<?php
    }
?>