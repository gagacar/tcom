<?php include($_SERVER['DOCUMENT_ROOT']."/tcom/include/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>The Books Of Knjige</title>
<meta charset="utf-8">
<link href="css/css.css" rel="stylesheet" type="text/css">
<?php include($_SERVER['DOCUMENT_ROOT']."/tcom/js/jquery_popup.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT']."/tcom/js/date.php"); ?>
</head>

<body>
	<?php include($_SERVER['DOCUMENT_ROOT']."/tcom/form/index.php"); ?>
	<div id="sve">
		<div id="prostor">
			<header id="zaglavlje">
				<h1>The Books Of Knjige</h1>
			</header>
			<main>
			<section id="pretraga">
				<form method="post">
					<select name="authors" id="authors" class="padajuca_lista sirina_mala">
					
					</select>
					<select name="years" id="years" class="padajuca_lista sirina_mala">
					
					</select>
					<input type="text" name="search" id="search" class="polje sirina_srednja" />
					<input type="button" name="find" id="find" class="dugme dugme_trazi" value="Find" />
					<input type="button" name="reset" id="reset" class="dugme dugme_ponisti" value="Reset" />
					<input type="button" name="new" id="new" class="dugme dugme_novi skroz_desno" value="New" />
				</form>
			</section>
			<section id="sadrzaj">
			
			</section>
			</main>
			<footer id="podnozje">
				<p>&copy; 2018 by The Books Of Knjige</p>
			</footer>
		</div>
	</div>
</body>
</html>
