<?php
include '../FUNCTIONS/functions.php';

if (!empty($_GET["id"])) {
    addToCart_in_cart($_GET["id"]);
}
?>