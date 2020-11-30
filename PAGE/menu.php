<div id="menu">
    <div class="logo">
        <a href="index.php"><img src="../IMG/logo.jpg" alt="logo stránky"></a>
    </div>
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>
    <nav id="nav">
        <a href="index.php?page=movies&action=add&id=">FILMY</a>
        <a href="index.php?page=george_club">GEORGE CLUB</a>
        <a href="index.php?page=kontakt_formular">KONTAKT</a>
    </nav>
    <nav id="nav_prihlaseni">
        <?php
        if (isset($_SESSION["isLogged"]) == true) {
            echo '<a href="index.php?page=shopping_cart">KOŠÍK  <img id="img_kosik" src="../IMG/nakupni_kosik.jpg" alt="nákupní košík"></a>';
            echo '<a href="index.php?page=account">MŮJ ÚČET</a>';
            echo '<a href="index.php?page=logout">ODHLÁSIT SE</a>';
            echo '<a href="#">Přihlášen: ' . $_SESSION["uzivatelske_jmeno"] . '</a>';
        } else {
            echo '<a href="index.php?page=shopping_cart">KOŠÍK  <img id="img_kosik" src="../IMG/nakupni_kosik.jpg" alt="nákupní košík"></a>';
            echo '<a href="index.php?page=login">PŘIHLÁSIT SE</a>';
        }
        ?>
    </nav>
</div>