<?php
include '../SQL/sql_commands.php';
include '../FUNCTIONS/functions.php';
$conn = connectToDatabase();

if($_POST) {
    insertIntoUzivateleAdmin();
    header("Location: index.php?page=account");
}
?>
<body class ="body_index_form">
<section class="formular_sekce">
    <form action="index.php?page=createUser" method="post">
        <div class="radek_formular">
            <label class="label_formular">Uživ. jméno: </label>
            <input name="uzivatelske_jmeno" type="text">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Email: </label>
            <input name="email" type="email">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Heslo: </label>
            <input name="heslo" type="password">
        </div>
        <div class="radek_formular">
            <label class="label_formular">Role: </label>
            <select id="role" name="role">
                <option>administrator</option>
                <option>registrovany</option>
            </select>
        </div>
        <div class="radek_formular">
            <input id="submit" type="submit" value="Uložit">
        </div>
    </form>
</section>