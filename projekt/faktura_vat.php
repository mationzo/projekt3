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
        <li><a href="kod pocztowy.php">Kod pocztowy</a></li>
        <li><a href="faktura_vat.php">Faktura VAT</a></li>
    </ul>

    <div class="container">
    <h1>Lista faktur VAT:</h1>
<table>
    <tr>
        <th>ID</th>
        <th>ID klienta</th>
        <th>Data faktury</th>
        <th>Numer faktury</th>
        <th>Akcje</th>
    </tr>
    <?php
    $do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
    mysqli_set_charset($do_bazy, "utf8");
    if (mysqli_connect_errno()) {
        echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
        exit;
    }

    if (!empty($_POST['id_klienta']) && !empty($_POST['data_faktury']) && !empty($_POST['numer_faktury'])) {
        $id_klienta = $_POST['id_klienta'];
        $data_faktury = $_POST['data_faktury'];
        $numer_faktury = $_POST['numer_faktury'];

        if (isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];

            $sql = "UPDATE faktura_vat SET ID_Kl = '$id_klienta', Data_faktury = '$data_faktury', Numer_faktury = '$numer_faktury' WHERE ID_Fakt_vat = $edit_id";

            if (mysqli_query($do_bazy, $sql)) {
                echo '<script>window.location.href = "faktura_vat.php";</script>';
                exit;
            } else {
                echo "Błąd: " . mysqli_error($do_bazy);
            }
        } else {

            $sql = "INSERT INTO faktura_vat (ID_Kl, Data_faktury, Numer_faktury) VALUES ('$id_klienta', '$data_faktury', '$numer_faktury')";

            if (mysqli_query($do_bazy, $sql)) {
                echo '<script>window.location.href = "faktura_vat.php";</script>';
                exit;
            } else {
                echo "Błąd: " . mysqli_error($do_bazy);
            }
        }
    }

    if ($result = mysqli_query($do_bazy, 'SELECT * FROM faktura_vat')) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ID_Fakt_vat'] . "</td>";
            echo "<td>";
            if (isset($_GET['edit']) && $_GET['edit'] == $row['ID_Fakt_vat']) {
                echo "<form method='POST' action='faktura_vat.php'>";
                echo "<input type='hidden' name='edit_id' value='" . $row['ID_Fakt_vat'] . "'>";
                echo "<input name='id_klienta' type='text' value='" . $row['ID_Kl'] . "'>";
                echo "</td>";
                echo "<td><input name='data_faktury' type='text' value='" . $row['Data_faktury'] . "'></td>";
                echo "<td><input name='numer_faktury' type='text' value='" . $row['Numer_faktury'] . "'></td>";
                echo "<td><button type='submit'>Zapisz</button></td>";
                echo "</form>";
            } else {
                echo $row['ID_Kl'];
                echo "</td>";
                echo "<td>" . $row['Data_faktury'] . "</td>";
                echo "<td>" . $row['Numer_faktury'] . "</td>";
                echo "<td><a href='faktura_vat.php?edit=" . $row['ID_Fakt_vat'] . "'>Edytuj</a></td>";
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
<h2>Dodaj nową fakturę VAT:</h2>
<form method="POST" action="faktura_vat.php" class="form-container">
    <label>ID klienta:</label>
    <input type="text" name="id_klienta" style="width: 250px;"><br><br>
    <label>Data faktury:</label>
    <input type="text" name="data_faktury" style="width: 250px;"><br><br>
    <label>Numer faktury:</label>
    <input type="text" name="numer_faktury" style="width: 250px;"><br><br>
    <button type="submit">Dodaj</button>
</form>

    </div>
</body>
</html>
