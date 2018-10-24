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
				<br>
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
			</div>
		</div>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
			$.getJSON('get_info_drugs.php', function(data){

				var infos = [];

				// var infos = "";

				$.each(data, function(key, drugs){
					infos.push(
						'<tr>\
							<td>'+ drugs.code +'</td>\
							<td>'+ drugs.name +'</td>\
							<td>'+ drugs.dayParth +'</td>\
							<td>'+ drugs.ingestion +'</td>\
							<td>'+ drugs.howManyTimes +'</td>\
							<td>'+ drugs.description +'</td>\
						</tr>'
					);
				});
				
				$("table#drugs_infos").append(infos.join(""));
			});
		</script>
	</body>
</html>