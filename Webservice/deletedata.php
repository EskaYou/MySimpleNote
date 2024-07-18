<?php
include("..\App\Config.php");
include("..\App\MainPDO.php");

$pdo = new MainPDO($config);

$data_id = $_POST["note"];

// Get all data
//$query = "SELECT notes.id, notes.title, notes.text, notes.user, user.nama FROM notes JOIN user ON notes.user=user.id WHERE user.id=:user_id AND notes.id=:note_id";
$query = "DELETE FROM notes WHERE id=:note_id";
$data = ["note_id" => $data_id];
$item = $pdo->ExecuteQueryMethod($query, $data, true);
header("content-type: application/json");

if($item < -1)
{
    echo json_encode(true);
}
else
{
    echo json_encode(false);
}

?>
