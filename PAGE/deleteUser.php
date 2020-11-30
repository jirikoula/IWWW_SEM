<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

$stmt = deleteFromUzivatele();

if ($stmt->rowCount() == 1) {
    header("location: index.php?page=account");
}