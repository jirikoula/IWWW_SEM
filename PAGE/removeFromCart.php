<?php
include '../FUNCTIONS/functions.php';

if (!empty($_GET["id"])) {
    removeFromCart($_GET["id"]);
}
?>