<?php
include("..\App\Config.php");
include("..\App\MainPDO.php");

$pdo = new MainPDO($config);

$user_id = $_GET["user"];
$data_id = $_GET["note"];

// Get all data
$query = "SELECT notes.id, notes.title, notes.text, notes.user, user.nama FROM notes JOIN user ON notes.user=user.id WHERE user.id=:user_id AND notes.id=:note_id";
$data = ["user_id" => $user_id, "note_id" => $data_id];
$item = $pdo->ExecuteFetchMethod($query, $data);
header("content-type: application/json");
echo json_encode($item);

?>
