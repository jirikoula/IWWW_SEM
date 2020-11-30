<?php
include '../FUNCTIONS/functions.php';

if (!empty($_GET["id"])) {
    deleteFromCart($_GET["id"]);
}
?>