<?php
session_start();

?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body class ="body_index">

<?php
include "menu.php";
?>

<section id="hero">
    <h1 class="nadpis">George Movies</h1>
</section>

<div class="galerie">
    <h2>Brzy v nabídce</h2>
</div>
<?php
include "../FILMY/prehled_filmy.php";
include "footer.php";
?>

</body>
</html>