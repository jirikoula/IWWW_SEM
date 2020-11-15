<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "databaze_kino";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare(
        " DELETE FROM uzivatele WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        header("location: account.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
