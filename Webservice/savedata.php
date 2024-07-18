<?php
include("..\App\Config.php");
include("..\App\MainPDO.php");

$pdo = new MainPDO($config);
$title = $_POST["title"];
$text = $_POST["text"];
$user = $_POST["user"];

if($title != "" && $text != "")
{
    $query = "INSERT INTO notes(title, text, user, created_at) VALUES(:title, :text, :user, :created_at);";
    $data = [
	"title" => htmlspecialchars($title),
	"text" => htmlspecialchars($text),
	"user" => htmlspecialchars($user),
	"created_at" => date("Y-m-d")
    ];
    $note = $pdo->ExecuteQueryMethod($query, $data);
    if($note > -1)
    {
	$query_ls = "SELECT notes.id, notes.title, notes.text, notes.user, user.nama, created_at FROM notes JOIN user ON notes.user=user.id WHERE notes.id=:notes_id";
	$data_ls = ["notes_id" => $note];
	$returned_data = $pdo->ExecuteFetchMethod($query_ls, $data_ls);
	if($returned_data != null)
	{
	    echo json_encode($returned_data);
	}
	else
	{
	    echo json_encode("Gagal mengembalikan data");
	}
	//echo json_encode($returned_data); //json_encode("Insert data berhasil ".$note);
    }
    else
    {
	echo json_encode("Insert data gagal :(");
    }
}


?>
