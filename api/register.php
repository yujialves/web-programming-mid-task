<?php

session_start();
require_once("../config.php");

if (!isset($_SESSION["user"])) {
    echo json_encode([]);
    exit();
}

if (!isset($_POST["begin"]) || !isset($_POST["end"]) || !isset($_POST["place"]) || !isset($_POST["content"])) {
    echo json_encode([]);
    exit();
}

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
    $id = $row["id"];

    $sql = "INSERT INTO schedules (user_id, begin, end, place, content) VALUES (:user_id, :begin, :end, :place, :content)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
    $stmt->bindValue(':end', $end, PDO::PARAM_STR);
    $stmt->bindValue(':place', $place, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();

    $sql = "SELECT * FROM schedules WHERE user_id = :user_id ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
