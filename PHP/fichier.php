<?php
//Connexion a notre base de donnee
try{
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=drugs', 'root', '');
}catch(Exception $e){
	echo "Exception recue : ", $e->getMessage(), "\n";
}



// Si on appuie sur le bouton (Je m'inscris) il verifie d'abord
if (isset($_POST['formregistrate'])) {

	// Codage de nos entrees
	$code = htmlspecialchars($_POST['code']);
	$name = htmlspecialchars($_POST['name']);
	$dayParth = htmlspecialchars($_POST['dayParth']);
	$ingestion = htmlspecialchars($_POST['ingestion']);
	$howManyTimes = htmlspecialchars($_POST['howManyTimes']);
	$description = htmlspecialchars($_POST['description']);
	
	// On verifie si nos donnees ne sont pas vides
	if (!empty($_POST['code']) AND !empty($_POST['name']) AND !empty($_POST['dayParth']) AND !empty($_POST['ingestion']) AND !empty($_POST['howManyTimes']) AND !empty($_POST['description'])) {

		//On verifie si le pseudo n'est pas deja utilise
		$reqcode = $bdd->prepare("SELECT * FROM medicament WHERE code = ?");
		$reqcode->execute(array($code));
		$codeexist = $reqcode->rowCount();

		if ($codeexist == 0) {
			$insertDrugs = $bdd->prepare("INSERT INTO medicament(code, name, dayParth, ingestion, howManyTimes, description) VALUES(?, ?, ?, ?, ?, ?)");
			$insertDrugs->execute(array($code, $name, $dayParth, $ingestion, $howManyTimes, $description));
			$good = "Registration done !!!";
		}
		else{
			$erreur = "That code exists, try again please...";
		}
	}
	else {
		$erreur = "Fields empty, they must be complete !!!";
	}
}



		


?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Tutos - Espace membre</title>
		<link rel="stylesheet" href="style/style.css">
	</head>
	<body>

		<header>
			<nav>
				<ul>
					<li><a href="#">Main</a></li>
					<li><a href="#">New</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Informations</a></li>
					<li><a href="#">About us</a></li>
				</ul>
			</nav>
		</header>

		<div align="center">
			<h2 align="center">Registration of drugs</h2>
			<br /><br /><br />
			<?php
				if (isset($good)) {
					echo '<font color="green">'.$good.'</font>';
				}
			?>
			<br><br>
			<form method="POST" action="">
				<table>
					<tr>
						<td align="right">
							<label for="code">Code : </label>
						</td>
						<td>
							<input type="text" id="code" placeholder="77444453546" name="code"/>
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="name">Name : </label>
						</td>
						<td>
							<input type="text" id="name" placeholder="Paracetamol" name="name"/>
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="dayParth">DayParth : </label>
						</td>
						<td>
							<input type="text" id="dayParth" placeholder="1,0,2,1" name="dayParth"/>
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="ingestion">Ingestion : </label>
						</td>
						<td>
							<input type="text" id="ingestion" placeholder="1,0,2" name="ingestion" />
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="howManyTimes">Usage in a day : </label>
						</td>
						<td>
							<input type="text" id="howManyTimes" placeholder="3" name="howManyTimes"/>
						</td>
					</tr>

					<tr>
						<td align="right">
							<label for="description">Description : </label>
						</td>
						<td>
							<textarea type="text" id="description" name="description" placeholder="Description"></textarea>
						</td>
					</tr>

					<tr>
						<td></td>

						<td align="center">
							<br>
							<input type="submit" name="formregistrate" Value="J'inscrire" />
						</td>	
					</tr>
				</table>
			</form>
			<br>
			<div align="center">
			<?php
				if (isset($erreur)) {
					echo '<font color="red">'.$erreur.'</font>';
				}
			?>
			</div>
		</div>
	</body>
</html>