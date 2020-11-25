<?php
session_start();

?>
<!DOCTYPE html>
<html lang="cs">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css ">
<?php
include "html_head.php";
?>
<body class ="body_index_form">

<?php
include "menu.php";
?>

<?php
$pathToFile = null;
if(!empty($_GET["page"])){
    $pathToFile = $_GET["page"] . ".php";
}
if (file_exists($pathToFile)) {
    include $pathToFile;
} else {
    include "mainPage.php";
}
?>


<?php
include "footer.php";
?>

</body>
</html>