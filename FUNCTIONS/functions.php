<?php
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "databaze_kino";

    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}

function addToCart($productId)
{
    if(empty($_SESSION["cart"]) == true) {
        $_SESSION["cart"][$productId]["quantity"] = 1;
    } else {
        if(!array_key_exists($productId, $_SESSION["cart"])) {
            $_SESSION["cart"][$productId]["quantity"] = 1;
        } else {
            $_SESSION["cart"][$productId]["quantity"]++;
        }
    }
}

function addToCart_in_cart($productId)
{
    if (!array_key_exists($productId, $_SESSION["cart"])) {
        $_SESSION["cart"][$productId]["quantity"] = 1;
    } else {
        $_SESSION["cart"][$productId]["quantity"]++;
    }
    header("Location: index.php?page=shopping_cart");
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
    header("Location: index.php?page=shopping_cart");
}

function deleteFromCart($productId)
{
    unset($_SESSION["cart"][$productId]);

    header("Location: index.php?page=shopping_cart");
}
