<?php

if (!empty($_GET["id"])) {
    deleteFromCart($_GET["id"]);
}

function deleteFromCart($productId)
{
    unset($_SESSION["cart"][$productId]);
}

header("Location: index.php?page=shopping_cart");


?>