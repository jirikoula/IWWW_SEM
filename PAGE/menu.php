<div id="menu">
    <div class="logo">
        <a href="index.php"><img src="../IMG/logo.jpg" alt="logo stránky"></a>
    </div>
    <label for="hamburger">&#9776;</label>
    <input type="checkbox" id="hamburger"/>
    <nav id="nav">
        <a href="new_movies.php">NOVÉ FILMY</a>
        <a href="dvd_movies.php">DVD FILMY</a>
        <a href="blu_ray_movies.php">BLU-RAY FILMY</a>
        <a href="george_club.php">GEORGE CLUB</a>
        <a href="form.php">KONTAKT</a>
    </nav>
    <style>
        #img_kosik {
            height: 18px;
        }
    </style>
    <nav id="nav_prihlaseni">
        <?php
        if (isset($_SESSION["isLogged"]) == true) {
            echo '<a href="../PAGE/shopping_cart.php">KOŠÍK  <img id="img_kosik" src="../IMG/nakupni_kosik.jpg" alt="nákupní košík"></a>';
            echo '<a href="../PAGE/account.php">MŮJ ÚČET</a>';
            echo '<a href="../PAGE/logout.php">ODHLÁSIT SE</a>';
            echo '<a href="#">Přihlášen: ' . $_SESSION["uzivatelske_jmeno"] . '</a>';
        } else {
            echo '<a href="../PAGE/shopping_cart.php">KOŠÍK  <img id="img_kosik" src="../IMG/nakupni_kosik.jpg" alt="nákupní košík"></a>';
            echo '<a href="../PAGE/login.php">PŘIHLÁSIT SE</a>';
        }
        ?>
    </nav>
</div>