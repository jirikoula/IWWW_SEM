<?php
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body class ="body_index_form">

<?php
include "menu.php";
?>

<h2 id="h2_black">Novinky - brzy v nabídce</h2>

<?php
include "../FILMY/prehled_filmy.php";
include "footer.php";
?>

</body>
</html>