<?php
session_name("note_app_user_auth");
session_start();
if(isset($_SESSION["note_app_client"]) == "")
{
    header("location: signin.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
	<title>Dashboard | LOLNote &#128514;</title>
	<link rel="stylesheet" href="Assets/css/Style.css">
    </head>
    <body>

	<nav class="navbar">
	    <div class="container">
		<div class="inner-navbar">
		    <h1 class="navbar-logo"><a href="dashboard.php">LOLNote &#128514;</a></h1>
		    <form action="signout.php" method="POST" style="">
			<button type="submit">Keluar</button>
		    </form>
		</div>
	    </div>
	</nav>

	<div class="container">
	    <div class="content-nav">
		<!-- <h1 class="content-nav-title" id="content-title"></h1> -->
		<div class="content-nav-item">
		    <button class="btn-primary" id="OnBtnAdd">+</button>
		</div>
		<div class="clear"></div>
	    </div>
	</div>

	<!-- Note list -->
	<div id="note-list-container" class="container">
	    <div id="note-list">		
		<div class="clear"></div>
	    </div>	     
	</div>

	<!-- Note detail -->
	<div id="note-detail" class="container">
	    <div class="form-data" style="margin-bottom: 10px;">
		<button class="btn-primary" id="OnBtnBackToHomePage">Kembali</button>
		<button class="btn-primary" id="OnBtnEditNote">Edit</button>
		<button class="btn-danger" id="OnBtnDeleteNote">Hapus</button>

		<div id="note-detail-content">
		    <span class="note-id" id="note-detail-id"></span>
		    <h1 class="note-detail-title" id="note-detail-title-data"></h1>
		    <div class="note-detail-text" id="note-detail-text-data"></div>
		</div>
	    </div>
	</div>

	<!-- Input data form -->
	<div id="note-form-container" class="container">
	    <form id="note_form" class="form-data">
		<input type="text" name="title" id="title" class="form-input" placeholder="Judul" />
		<textarea name="text" id="text" rows="14" cols="50" class="form-input" placeholder="Isi catatan"></textarea>
		<input type="hidden" name="user" id="user-form" value="<?php echo $_SESSION["note_app_client"];?>"/>
		<input type="hidden" name="note" id="note-form" value=""/>
		<button type="submit" name="SaveNote" id="OnSaveNoteBtn" class="btn-primary">Simpan</button>
	    </form>
	</div>

	<script src="Assets/js/DataListLoader.js"></script>
	<script>
	 var user = <?php echo $_SESSION["note_app_client"];?>;
	 LoadAllData(<?php echo $_SESSION["note_app_client"];?>);
	</script>
    </body>
</html>
