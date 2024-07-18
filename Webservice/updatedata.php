<?php
include("..\App\Config.php");
include("..\App\MainPDO.php");

$pdo = new MainPDO($config);
$note_id = $_POST["note"];
$title = $_POST["title"];
$text = $_POST["text"];
$user = $_POST["user"];

if($title != "" && $text != "")
{
    $query = "UPDATE notes SET title=:title, text=:text, user=:user, created_at=:created_at WHERE id=:note_id";
    $data = [
	"note_id" => htmlspecialchars($note_id),
	"title" => htmlspecialchars($title),
	"text" => htmlspecialchars($text),
	"user" => htmlspecialchars($user),
	"created_at" => date("Y-m-d")
    ];

    $note = $pdo->ExecuteQueryMethod($query, $data, true);
    if($note < -1)
    {
    	$query_ls = "SELECT notes.id, notes.title, notes.text, notes.user, user.nama, created_at FROM notes JOIN user ON notes.user=user.id WHERE notes.id=:notes_id";
    	$data_ls = ["notes_id" => $note_id];
    	$returned_data = $pdo->ExecuteFetchMethod($query_ls, $data_ls);
    	if($returned_data != null)
    	{
    	    echo json_encode($returned_data);
    	}
    	else
    	{
    	    echo json_encode("Gagal mengembalikan data");
    	}
    }
    else
    {
    	echo json_encode("Update data gagal :(");
    }
}


?>
