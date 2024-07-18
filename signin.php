<?php
include("App\Config.php");
include("App\MainPDO.php");

$fail_check = false;
$pdo = new MainPDO($config);

if(isset($_POST["user_signin"]))
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    session_name("note_app_user_auth");
    session_start();

    if($email != "" && $password != "")
    {
	$query = "SELECT * FROM user WHERE email=:email && password=:password";
	$data = [
	    "email" => $email,
	    "password" => $password
	];
	$user = $pdo->ExecuteFetchMethod($query, $data);
	if($user != null)
	{   
	    $_SESSION["note_app_client"] = $user->id;
	    header("location: dashboard.php");
	}
	else
	{
	    //echo "LOL nggak bisa login... rasain....";
	    $fail_check = true;
	}
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
	<title>Masuk | LOLNote &#128514;</title>
	<link rel="stylesheet" href="Assets/css/Style.css">
    </head>
    <body>
	<?php if($fail_check == true){ ?>
	    <?php echo "<h1 style='font-size: 20px; width: 50%; margin: 0 auto; padding-top: 40px; padding-bottom: 0; margin-bottom: 0;'>LOL nggak bisa login.. &#128540;, coba lagi, kalau sukses selamat kalau nggak yasudah.. nasib kamu itu, bercanda, coba daftar yang baru aja, OKE &#128077;</h1>" ?>
	    <?php $fail_check = false; ?>
	<?php }  ?>
	<div class="container">	    
	    <form action="" method="POST" id="user_form" class="form-user-auth">
		<h1>Masuk | LOLNote &#128514;</h1>
		<label for="email">Email</label><br/>
		<input type="text" name="email" id="email" required/><br/><br/>
		<label for="email">Password</label><br/>
		<input type="password" name="password" id="password" required/><br/><br/>
		<button type="submit" id="OnUserSignin" name="user_signin" class="btn-primary">Masuk</button>
		<a href="signup.php">Belum punya akun, buat di sini!!</a><br/><br/>
		<a href="index.php">Ke halaman utama</a>
	    </form>
	</div>
    </body>
</html>
