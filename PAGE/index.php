<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="cs">
<?php
include "html_head.php";
?>
<body class ="body_index_form">

<?php
include "menu.php";

$pathToFile = null;
if(!empty($_GET["page"]) && preg_match("/^[a-z0-9A-Z-\._]+$/", $_GET["page"])){
    $pathToFile = $_GET["page"] . ".php";
}
if (file_exists($pathToFile)) {
    include $pathToFile;
} else {
    include "mainPage.php";
}

include "footer.php";
?>
</body>
</html>