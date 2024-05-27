<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warzywniak</title>
    <link rel="stylesheet" href="styl2.css">
</head>
<body>


    <div class="baner">
        <div id="baner_lewy"><h1>Internetowy sklep z eko-warzywami</h1></div>
        
        <div id="baner_prawy">
            <ol>
                <li>warzywa</li>
                <li>owoce</li>
                <li><a href="https://terapiasokami.pl/" target="_blank">soki</a></li>
            </ol>
        </div>
    </div>


    <div id="blok_główny">

        <?php
        //połączenie ze serwerem
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dane2";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }


        //Skrypt 2
        if(($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['skrypt2'])){

            $nazwa = $_POST['nazwa'];
            $cena = $_POST['cena'];

            if(empty($nazwa) || empty($cena)){
                $message = "Prosze wypełnić wszystkie pola!";
                echo "<script>alert('$message');</script>";
            }
            else{
                //Zapytanie 4 (modyfikowane)
            $stmt = $conn->prepare(
                "INSERT INTO produkty (Rodzaje_id, Producenci_id, nazwa, ilosc, opis, cena, zdjecie)
                VALUES (1, 4, ?, 10, NULL, ?, 'owoce.jpg'); 
                ");
            if ($stmt === false) {
                die('Błąd zapytania: ' . $conn->error);
            }
            else{
                echo '<script>alert("Produkt dodano!")</script>';
            }
            $stmt->bind_param("sd", $nazwa, $cena);
            $stmt->execute();
            $stmt->close();
            }
        
        }


        //Skrypt 1
        //Zapytanie 1
        $result = $conn->query("SELECT  nazwa, ilosc, opis, cena, zdjecie FROM produkty WHERE Rodzaje_id = 1 OR Rodzaje_id = 2;");
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {

                $opis = $row["opis"];
                if(empty($row["opis"])){
                    $opis = "brak";
                }

                echo '<div class="block_produktu" 
                style="
                    margin: 10px;
                    border: 1px solid #00600F;
                    width: 300px; "
                >';
                echo '
                <img src="' . $row["zdjecie"] . '" alt="warzywniak" 
                style=" width: 300px; height: 200px; ">
                <h5>' . $row["nazwa"] . '</h5>  
                <p>opis: ' . $opis . '</p>
                <p>na stanie: ' . $row["ilosc"] . '</p>
                <h2> ' . $row["cena"] . ' zł</h2>
                ';
                echo '</div>';
            }
        }
        else {
            echo "Brak wyników";
        }

        mysqli_close($conn);
        ?>

    </div>


    <div id="stopka">
        <form action="sklep.php" method="POST" >
            <label for="nazwa">Nazwa</label>
            <input type="text" id="nazwa" name="nazwa">
            <label for="cena">Cena</label>
            <input type="text" id="cena" name="cena">

            <input type="submit" name="skrypt2" value="Dodaj produkt">
        </form>
        <p>Stronę wykonała: 66617</p>
        <p>Copyright &#169 Anastasiia Bzova</p>
    </div>


</body>
</html>