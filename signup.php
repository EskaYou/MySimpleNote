<?php
include("App\Config.php");
include("App\MainPDO.php");

$pdo = new MainPDO($config);

if(isset($_POST["user_signup"]))
{
    $nama = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    session_name("note_app_user_auth");
    session_start();

    if($nama != "" && $email != "" && $password != "")
    {
	$query = "INSERT INTO user(nama, email, password) VALUES (:nama, :email, :password)";
	$data = [
	    "nama" => $nama,
	    "email" => $email,
	    "password" => $password
	];
	$user = $pdo->ExecuteQueryMethod($query, $data);
	if($user == TRUE)
	{
	    // Ambil user id, ehhh..jadi dua kali select ke databasenya
	    $query = "SELECT id FROM user WHERE email=:email";
	    $data = ["email" => $email];
	    $user = $pdo->ExecuteFetchMethod($query, $data);
	    
	    $_SESSION["note_app_client"] = $user->id;
	    header("location: dashboard.php");
	}
	else
	{
	    echo "Gagal buat akun :(";
	}
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
	<title>Daftar | LOLNote &#128514; </title>
	<link rel="stylesheet" href="Assets/css/Style.css">
    </head>
    <body>
	<div class="container">
	    <form action="" method="POST" id="user_form" class="form-user-auth">
		<h1>Daftar | LOLNote &#128514;</h1>
		<label for="name">Nama</label><br/>
		<input type="text" name="name" id="name" required/><br/><br/>
		<label for="email">Email</label><br/>
		<input type="text" name="email" id="email" required/><br/><br/>
		<label for="email">Password</label><br/>
		<input type="password" name="password" id="password" required/><br/><br/>
		<button type="submit" id="OnUserSignin" name="user_signup" class="btn-primary">Daftar</button>
		<a href="signin.php">Sudah punya akun, masuk di sini!!</a><br/><br/>
		<a href="index.php">Ke halaman utama</a>
	    </form>
	</div>
    </body>
</html>
