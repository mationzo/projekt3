<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
	<style>
        .przycisk {
            margin: 1px;
            background-color: #454545;
            color: white;
            border-radius: 10px;
            

        }

        .divprzycisk {
            text-align: center;
        }

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
			margin-bottom: 10px;
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
		<li><a href="kod pocztowy.php">Kod pocztowy</a></li>
		<li><a href="faktura_vat.php">Faktura VAT</a></li>
	</ul>

	<div class="container">
		<h1>Lista nazwisk:</h1>
		<table>
			<tr>
				<th>ID_N</th>
				<th>Nazwisko</th>
                <th width=95px;>Akcje</th>
			</tr>
			<?php
				$do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
				mysqli_set_charset($do_bazy, "utf8");
				if (mysqli_connect_errno()) {
					echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
					exit;
				}

				if (!empty($_POST['pole'])) {
					$pole = $_POST['pole'];

					if (isset($_POST['edit_id'])) {
						$edit_id = $_POST['edit_id'];

						$sql = "UPDATE nazwiska SET Nazwisko = '$pole' WHERE ID_N = $edit_id";

						if (mysqli_query($do_bazy, $sql)) {
							echo '<script>window.location.href = "nazwiska.php";</script>';
							exit;
						} else {
							echo "Błąd: " . mysqli_error($do_bazy);
						}
					} else {

						$sql = "INSERT INTO nazwiska (Nazwisko) VALUES ('$pole')";

						if (mysqli_query($do_bazy, $sql)) {
							echo '<script>window.location.href = "nazwiska.php";</script>';
							exit;
						} else {
							echo "Błąd: " . mysqli_error($do_bazy);
						}
					}
				}

				if ($result = mysqli_query($do_bazy, 'SELECT * FROM nazwiska')) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $row['ID_N'] . "</td>";
						echo "<td>";
						if (isset($_POST['edit_id']) && $_POST['edit_id'] == $row['ID_N']) {
							echo "<form method='POST' action='nazwiska.php'>";
							echo "<input type='hidden' name='edit_id' value='" . $row['ID_N'] . "'>";
							echo "<input class='przycisk' name='pole' type='text' value='" . $row['Nazwisko'] . "'>";
							echo "</td>";
							echo "<td> <div class='divprzycisk'> <button class='przycisk' type='submit'>Zapisz</button></td></div>";
							echo "</form>";
						} else {
							echo $row['Nazwisko'];
							echo "</td>";
							echo "<td>";
							echo "<form method='POST' action='nazwiska.php'>";
							echo "<input class='przycisk' type='hidden' name='edit_id' value='" . $row['ID_N'] . "'>";
							echo "<div class='divprzycisk'> <button class='przycisk' type='submit'>Edytuj</button></div>";
							echo "</form>";
							echo "</td>";
						}
						echo "</tr>";
					}
				} else {
					echo "Brak danych do wyświetlenia";
				}

				mysqli_close($do_bazy);
			?>
		</table>

		<div class="form-container">
			<form method="POST" action="nazwiska.php">
				<label for="pole">Dodawanie nazwiska:</label><br>
				<input class="przycisk" name="pole" type="text" style="width: 200px;"><br>
				<button type="submit">Zapisz</button>
			</form>
		</div>
	</div>

	<div class="pusty"></div>
</body>
</html>
