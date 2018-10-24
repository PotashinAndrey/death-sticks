<?php

//Connexion to the database
try{
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=drugs', 'root', '');
}catch(Exception $e){
	echo "Exception recue : ", $e->getMessage(), "\n";
}

$output = '';

// Collection of data

if (isset($_POST['formsearch'])) {

	$searchq = $_POST['code'];

	$query = $bdd->query("SELECT * FROM medicament WHERE code LIKE '%searchq%'");
	
	// $count = $query->rowCount();

	// if ($count == 0){
	// 	$output = 'Nothing in the database....';
	// }
	//else{
		while($row =  $query->fetch(PDO::FETCH_ASSOC)) {
		$name = $row['name'];
		$dayParth = $row['dayParth'];
		$ingestion = $row['ingestion'];
		$howManyTimes = $row['howManyTimes'];
		$description = $row['description'];

		$output .= '<tr>\
			<td>'.$name.'</td>\
			<td>'.$dayParth.'</td>\
			<td>'.$ingestion.'</td>\
			<td>'.$howManyTimes.'</td>\
			<td>'.$description.'</td>
			<tr>';
		}
	//}

}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Drugs from database</title>
		<meta charset="UTF-8" ">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
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
			<div class="container">
				<h1>Informations about drugs</h1>
				<br><br><br>
				<form method="POST" action="index2.php">
					<table align="center" class="tableau">
						<tr>
							<td align="right">
								<label class="labell" for="code">Code : </label>
							</td>
							<td>
								<input type="search" id="code" placeholder="77444453546" name="code"/>
							</td>
							<td>
								<input type="submit" name="formsearch" Value="Search" />
							</td>
						</tr>
					</table>
				</form>

				<table id="drugs_infos" class="table table-striped table-bordered">
					<tr>
						<th>CODE</th>
						<th>NAME</th>
						<th>DAYPARTH</th>
						<th>INGESTION</th>
						<th>HOWMANYTIMES</th>
						<th>DESCRIPTION</th>
					</tr>
				</table>
				<?php ("$output"); ?>
			</div>
		</div>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</body>
</html>