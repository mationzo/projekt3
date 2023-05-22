<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #DFD6B9;
		}

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 200px;
			background-color: #696969;
			position: fixed;
			height: 100vh;
			overflow: auto;
			padding-left: 0px;
			top: 0;
			left: 0;
		}

		li a {
			display: block;
			color: #000;
			padding: 8px 16px;
			text-decoration: none;
			font-size: 24px;
		}

		li a.active {
			background-color: #545454;
			color: white;
		}

		li a:hover:not(.active) {
			background-color: #555;
			color: white;
		}

		.container {
			margin-left: 220px;
			padding: 25px;
		}

		.menu {
			position: static;
			font-size: 24px;
			background: #9C9C9C;
			border: outset black 3px;
			height: 50px;
			text-align: center;
			width: 16.66%;
			float: left;
			margin-bottom: 10px;
		}

		.menu a {
			color: black;
			text-decoration: none;
			line-height: 50px;
			height: 50px;
			display: block;
		}

		.pusty {
			clear: both;
		}

		table {
			border-collapse: collapse;
			width: 80%;
			margin-top: 20px;
		}

		th, td {
			border: 2px solid;
			padding: 8px;
			font-size: 18px;
		}

		th {
			background-color: #545454;
			color: white;
		}

		.form-container {
			margin-top: 20px;
		}

		.form-container label {
			font-size: 18px;
		}

		.form-container input[type="text"] {
			width: 100%;
			padding: 5px;
			font-size: 18px;
		}

		.form-container button {
			margin-top: 10px;
			padding: 8px 16px;
			font-size: 18px;
			background-color: #555;
			color: white;
			border: none;
			cursor: pointer;
		}

		.form-container button:hover {
			background-color: #333;
		}
	</style>
</head>
<body>
	<ul>
		<li><a href="menu.php" class="active">Strona Główna</a></li>
		<li><a href="imiona.php">Imiona</a></li>
		<li><a href="nazwiska.php">Nazwiska</a></li>
		<li><a href="klient.php">Klient</a></li>
		<li><a href="miasto.php">Miasto</a></li>
		<li><a href="ulice.php">Ulice</a></li>
		<li><a href="kod_pocztowy.php">Kod pocztowy</a></li>
		<li><a href="faktura_vat.php">Faktura VAT</a></li>
	</ul>

	<div class="container">
		<h1>Lista klientów:</h1>
		<table>
			<tr>
				<th>ID</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>Miasto</th>
				<th>Ulica</th>
				<th>Kod pocztowy</th>
				<th>Numer domu</th>
				<th>Numer mieszkania</th>
				<th>PESEL</th>
				<th>Nazwa firmy</th>
				<th>Numer NIP</th>
				<th>Numer telefonu</th>
				<th></th>
			</tr>
			<?php
				$do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
				mysqli_set_charset($do_bazy, "utf8");
				if (mysqli_connect_errno()) {
				  echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
				  exit;
				}

				if (!empty($_POST['imie']) && !empty($_POST['nazwisko'])) {
				  $imie = $_POST['imie'];
				  $nazwisko = $_POST['nazwisko'];

				  if (isset($_POST['edit_id'])) {
				    $edit_id = $_POST['edit_id'];

				    $sql = "UPDATE klient SET ID_imie2 = '$imie', ID_nazwi = '$nazwisko' WHERE ID_K = $edit_id";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "klient.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  } else {

				    $sql = "INSERT INTO klient (ID_imie2, ID_nazwi) VALUES ('$imie', '$nazwisko')";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "klient.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  }
				}

				if ($result = mysqli_query($do_bazy, 'SELECT * FROM klient ORDER BY ID_K')) {
				  while ($row = mysqli_fetch_assoc($result)) {
				    echo "<tr>";
				    echo "<td>" . $row['ID_K'] . "</td>";
				    echo "<td>";
				    if (isset($_POST['edit_id']) && $_POST['edit_id'] == $row['ID_K']) {
				      echo "<form method='POST' action='klient.php'>";
				      echo "<input type='hidden' name='edit_id' value='" . $row['ID_K'] . "'>";
				      echo "<input name='imie' type='text' value='" . $row['ID_imie2'] . "'>";
				      echo "</td>";
				      echo "<td><input name='nazwisko' type='text' value='" . $row['ID_nazwi'] . "'></td>";
				      echo "<td>" . $row['ID_mias'] . "</td>";
				      echo "<td>" . $row['ID_ulic'] . "</td>";
				      echo "<td>" . $row['ID_kodpocz'] . "</td>";
				      echo "<td>" . $row['Numer domu'] . "</td>";
				      echo "<td>" . $row['Numer mieszkania'] . "</td>";
				      echo "<td>" . $row['Pesel'] . "</td>";
				      echo "<td>" . $row['ID_naz_firmy'] . "</td>";
				      echo "<td>" . $row['Numer Nip'] . "</td>";
				      echo "<td>" . $row['Numer telefonu'] . "</td>";
				      echo "<td><button type='submit'>Zapisz</button></form></td>";
				    } else {
				      echo $row['ID_imie2'] . "</td>";
				      echo "<td>" . $row['ID_nazwi'] . "</td>";
				      echo "<td>" . $row['ID_mias'] . "</td>";
				      echo "<td>" . $row['ID_ulic'] . "</td>";
				      echo "<td>" . $row['ID_kodpocz'] . "</td>";
				      echo "<td>" . $row['Numer domu'] . "</td>";
				      echo "<td>" . $row['Numer mieszkania'] . "</td>";
				      echo "<td>" . $row['Pesel'] . "</td>";
				      echo "<td>" . $row['ID_naz_firmy'] . "</td>";
				      echo "<td>" . $row['Numer Nip'] . "</td>";
				      echo "<td>" . $row['Numer telefonu'] . "</td>";
				      echo "<td><form method='POST' action='klient.php'>";
				      echo "<input type='hidden' name='edit_id' value='" . $row['ID_K'] . "'>";
				      echo "<button type='submit'>Edytuj</button></form></td>";
				    }
				    echo "</tr>";
				  }
				  mysqli_free_result($result);
				} else {
				  echo "Brak danych do wyświetlenia";
				}

				mysqli_close($do_bazy);
			?>
		</table>

		<h2>Dodaj klienta:</h2>
		<div class="form-container">
			<form method="POST" action="klient.php">
				<label>Imię:</label>
				<input type="text" name="imie" style="width: 250px;" required>
        <br>
        <br>
				<label>Nazwisko:</label>
				<input type="text" name="nazwisko" style="width: 250px;"required>
        <br>
				<button type="submit">Dodaj</button>
			</form>
		</div>
	</div>
</body>
</html>
