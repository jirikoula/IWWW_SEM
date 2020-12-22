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

function cart_manager($action, $id)
{
    if($action == "add") {
        addToCart_in_cart($id);
    }
    if($action == "remove") {
        removeFromCart($id);
    }
    if($action == "delete") {
        deleteFromCart($id);
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

function administration_manager($action, $id)
{
    if($action == "delete") {
        $stmt = deleteFromUzivateleWhereId($id);
        if ($stmt->rowCount() == 1) {
            header("location: index.php?page=account");
        }
    } else if($action == "create") {
        header("location: index.php?page=createUser");
    } else if($action == "edit") {
        $_SESSION["edit_id"] = $id;
        header("location: index.php?page=editUser");
    }
}


