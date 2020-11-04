<?php

session_start();
require_once("../config.php");

if (!isset($_SESSION["user"])) {
    echo json_encode([]);
    exit();
}

if (!isset($_POST["id"]) || !isset($_POST["begin"]) || !isset($_POST["end"]) || !isset($_POST["place"]) || !isset($_POST["content"])) {
    echo json_encode([]);
    exit();
}

$id = $_POST["id"];
$begin = $_POST["begin"];
$end = $_POST["end"];
$place = $_POST["place"];
$content = $_POST["content"];

$dbname = DBNAME;
$host = HOST;

try {
    $pdo = new PDO("mysql:dbname={$dbname};host={$host}", DBUSER, DBPASS);
    $sql = "SELECT id FROM users WHERE user = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $_SESSION["user"], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row["id"];

    $sql = "UPDATE schedules SET begin = :begin, end = :end, place = :place, content = :content WHERE user_id = :user_id AND id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
    $stmt->bindValue(':end', $end, PDO::PARAM_STR);
    $stmt->bindValue(':place', $place, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();

    $sql = "SELECT * FROM schedules WHERE user_id = :user_id ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
