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
        <h1>Lista kodów pocztowych:</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Kod pocztowy</th>
                <th></th>
            </tr>
            <?php
            $do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
            mysqli_set_charset($do_bazy, "utf8");
            if (mysqli_connect_errno()) {
                echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
                exit;
            }

            if (!empty($_POST['kod'])) {
                $kod = $_POST['kod'];

                if (isset($_POST['edit_id'])) {
                    $edit_id = $_POST['edit_id'];

                    $sql = "UPDATE kod_pocztowy SET Kod = '$kod' WHERE Id_kod = $edit_id";

                    if (mysqli_query($do_bazy, $sql)) {
                        echo '<script>window.location.href = "kod pocztowy.php";</script>';
                        exit;
                    } else {
                        echo "Błąd: " . mysqli_error($do_bazy);
                    }
                } else {

                    $sql = "INSERT INTO kod_pocztowy (Kod) VALUES ('$kod')";

                    if (mysqli_query($do_bazy, $sql)) {
                        echo '<script>window.location.href = "kod pocztowy.php";</script>';
                        exit;
                    } else {
                        echo "Błąd: " . mysqli_error($do_bazy);
                    }
                }
            }

            if ($result = mysqli_query($do_bazy, 'SELECT * FROM kod_pocztowy')) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Id_kod'] . "</td>";
                    echo "<td>";
                    if (isset($_POST['edit_id']) && $_POST['edit_id'] == $row['Id_kod']) {
                        echo "<form method='POST' action='kod_pocztowy.php'>";
                        echo "<input type='hidden' name='edit_id' value='" . $row['Id_kod'] . "'>";
                        echo "<input name='kod' type='text' value='" . $row['Kod'] . "'>";
                        echo "</td>";
                        echo "<td><button type='submit'>Zapisz</button></td>";
                        echo "</form>";
                    } else {
                        echo $row['Kod'];
                        echo "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='kod pocztowy.php'>";
                        echo "<input type='hidden' name='edit_id' value='" . $row['Id_kod'] . "'>";
                        echo "<button type='submit' style='color: black;'>Edytuj</button>";
                        echo "</form>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            }

            mysqli_close($do_bazy);
            ?>
        </table>

        <div class="form-container">
            <form method="POST" action="kod pocztowy.php">
                <label for="kod">Dodawanie kodu pocztowego:</label><br>
                <input name="kod" type="text"><br>
                <button type="submit">Zapisz</button>
            </form>
        </div>
    </div>

    <div class="pusty"></div>
</body>
</html>
