<?php

if (!empty($_GET["id"])) {
    addToCart($_GET["id"]);
}

function addToCart($productId)
{
    if (!array_key_exists($productId, $_SESSION["cart"])) {
        $_SESSION["cart"][$productId]["quantity"] = 1;
    } else {
        $_SESSION["cart"][$productId]["quantity"]++;
    }
}

header("Location: index.php?page=shopping_cart");
?>