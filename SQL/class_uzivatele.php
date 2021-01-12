<?php

class Uzivatele {

    function selectAllFromUzivatele($uzivatelske_jmeno_u) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT * FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno");
        $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_u);
        $stmt->execute();

        return $stmt;
    }

    function selectIdFromUzivateleWhereName() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id FROM uzivatele WHERE uzivatelske_jmeno = :uzivatelske_jmeno");
        $stmt->bindParam(":uzivatelske_jmeno", $param_userName, PDO::PARAM_STR);
        $param_userName = trim($_POST["uzivatelske_jmeno"]);
        $stmt->execute();

        return $stmt;
    }

    function selectIdFromUzivateleWhereEmail() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id FROM uzivatele WHERE email = :email");
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = trim($_POST["email"]);
        $stmt->execute();

        return $stmt;
    }

    function insertIntoUzivatele() {
        $conn = connectToDatabase();

        $userName = htmlspecialchars($_POST["uzivatelske_jmeno"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["heslo"]);
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'registrovany';
        $stmt = $conn->prepare("INSERT INTO uzivatele (uzivatelske_jmeno, email, heslo, role) VALUES (:uzivatelske_jmeno, :email, :heslo, :role)");

        $stmt->bindParam(':uzivatelske_jmeno', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':heslo', $hashPassword);
        $stmt->bindParam(':role', $role);

        $stmt->execute();
        return $stmt;
    }

    function insertIntoUzivateleAdmin() {
        $conn = connectToDatabase();

        $userName = htmlspecialchars($_POST["uzivatelske_jmeno"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["heslo"]);
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = htmlspecialchars($_POST["role"]);
        $stmt = $conn->prepare("INSERT INTO uzivatele (uzivatelske_jmeno, email, heslo, role) VALUES (:uzivatelske_jmeno, :email, :heslo, :role)");

        $stmt->bindParam(':uzivatelske_jmeno', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':heslo', $hashPassword);
        $stmt->bindParam(':role', $role);

        $stmt->execute();
        return $stmt;
    }

    function deleteFromUzivateleWhereId($id) {
        $conn = connectToDatabase();

        $stmt = $conn->prepare(" DELETE FROM uzivatele WHERE id = $id");
        $stmt->execute();

        return $stmt;
    }

    function selectFromUzivateleAdmin() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT id, uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele");
        $stmt->execute();

        return $stmt;
    }

    function selectFromUzivatele() {
        $conn = connectToDatabase();

        $stmt = $conn->prepare("SELECT uzivatelske_jmeno, email, jmeno, prijmeni, role FROM uzivatele WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->execute();

        return $stmt;
    }

    function updateUzivatele() {
        $conn = connectToDatabase();

        $uzivatelske_jmeno_nove = htmlspecialchars($_POST["uzivatelske_jmeno"]);
        $email_novy = htmlspecialchars($_POST["email"]);
        $jmeno_nove = htmlspecialchars($_POST["jmeno"]);
        $prijmeni_nove = htmlspecialchars($_POST["prijmeni"]);
        $role_nova = htmlspecialchars($_POST["role"]);

        $stmt = $conn->prepare("UPDATE uzivatele SET uzivatelske_jmeno = :uzivatelske_jmeno, email = :email, jmeno = :jmeno, prijmeni = :prijmeni, role = :role WHERE id = :id");

        $stmt->bindParam(':id', $_SESSION["edit_id"]);
        $stmt->bindParam(':uzivatelske_jmeno', $uzivatelske_jmeno_nove);
        $stmt->bindParam(':email', $email_novy);
        $stmt->bindParam(':jmeno', $jmeno_nove);
        $stmt->bindParam(':prijmeni', $prijmeni_nove);
        $stmt->bindParam(':role', $role_nova);
        $stmt->execute();

        header("Location: index.php?page=tableUzivatele");
    }
}