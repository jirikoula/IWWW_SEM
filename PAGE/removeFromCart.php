<?php
if (!empty($_GET["id"])) {
    removeFromCart($_GET["id"]);
}

function removeFromCart($productId)
{
    if (array_key_exists($productId, $_SESSION["cart"])) {
        if ($_SESSION["cart"][$productId]["quantity"] <= 1) {
            unset($_SESSION["cart"][$productId]);
        } else {
            $_SESSION["cart"][$productId]["quantity"]--;
        }
    }
}

header("Location: index.php?page=shopping_cart");
?>