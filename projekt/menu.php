<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
	<style>
        

    body {
         margin: 0;
         padding: 0;

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

		.tt {
			margin-top: 25px;
			margin-left: 225px;
		}
		table, tr, td{
			border: 1.5px solid;
			border-collapse: collapse;
            padding: 2px;
            font-size: 28px;
            width: auto;
		}
		th {
			background-color: #545454;
			color: white;
		}

        ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #f1f1f1;
        position: fixed;
        height: 36%;
        overflow: auto;
        padding-left: 0px;
        top: 0;
        left: 0;
        }

        .menu {
        float: left;
        margin-top: 0;
        }

	</style>
</head>
<body>
<ul>
<li><a href="menu.php">Strona Główna</a></li>
        <li><a href="imiona.php">Imiona</a></li>
		<li><a href="nazwiska.php">Nazwiska</a></li>
        <li><a href="klient.php">Klient</a></li>
        <li><a href="miasto.php">Miasto</a></li>
        <li><a class="active" href="ulice.php">Ulice</a></li>
        <li><a href="kod pocztowy.php">Kod pocztowy</a></li>
		<li><a href="faktura_vat.php">Faktura_vat</a></li>

		<!-- <li><a href="nazwy firm.php">nazwy firm</a></li>
		<li><a href="nazwy towarow.php">nazwy towarów</a></li>
		<li><a href="pozycja faktury.php">pozycja faktury</a></li>
		<li><a href="rodzaje towaru.php">rodzaje towaru</a></li>
		<li><a href="towar.php">towar</a></li>
		<li><a href="vat.php">vat</a></li> -->
	</ul>
		
        


</body>
</html>
