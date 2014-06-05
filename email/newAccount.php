<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $data['type_of_email']; ?></title>
</head>
<body>
	<div id="wrapper">	
		<div class="header">
			Dein neuer Account im Internen Bereich von <?php echo $_SERVER['SERVER_NAME']; ?>
		</div>
		<div class="container">
			<div class="single-column">
				<h1>Hallo <?php echo $data['firstname'] ?></h1>
				<p class="lead">
					Deine Login-Daten für den Account auf <?php echo $_SERVER['SERVER_NAME']; ?> lauten:
				</p>
				<p class="lead">
					Nutzername: <?php echo $data['recipient_email']; ?><br>
					Passwort: <?php echo $data['password']; ?>
				</p>
				<p class="lead">
					Du kannst dich unter <a href="<?php echo $data['url']; ?>"><?php echo $data['url']; ?></a> einloggen.
				</p>
			</div>
		</div>
	</div>
</body>
</html>