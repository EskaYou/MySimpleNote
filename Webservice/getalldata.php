<?php
include("..\App\Config.php");
include("..\App\MainPDO.php");

$pdo = new MainPDO($config);
$user_id = $_GET["user"];

// Get all of current user notes
$query = "SELECT notes.id, notes.title, notes.text, notes.user, user.nama, created_at FROM notes JOIN user ON notes.user=user.id WHERE user.id=:id";
$data = ["id" => $user_id];
$items = $pdo->ExecuteFetchMethod($query, $data, TRUE);
header("content-type: application/json");
echo json_encode($items);

?>
