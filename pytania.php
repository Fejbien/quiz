<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    $max = $db->query("SELECT COUNT(`id`) as `max` FROM `pytania` WHERE 1;")->fetch_assoc()["max"];
    $losowePytanie = rand(1, $max);

    $pytania = "SELECT `id`, `pytanie` FROM `pytania` WHERE id = ".$losowePytanie.";";
    if($results = $db->query($pytania)){
        while($row = $results->fetch_assoc()){
            echo "<p>".$row["pytanie"]."</p>";
            
            $odpowiedzi = "SELECT `id`, `odpowiedz`, `poprawna` FROM `odpowiedzi` WHERE id_pytania = ".$row["id"].";";
            if($resultsAns = $db->query($odpowiedzi)){
                while($rowAns = $resultsAns->fetch_assoc()){
                    echo "<form action='odpowiedzi.php' method='POST'>";
                    echo "<input type='hidden' id='odpowiedzID' name='odpowiedzID' value=".$rowAns["id"]."/>";
                    echo "<input type='hidden' id='pytanieID' name='pytanieID' value=".$row["id"]."/>";
                    echo "<input type='submit'/>".$rowAns["odpowiedz"]."</form>";
                }
            }
        }
    }
    else{
        echo "error: $db->error";
    }
    $db->close();
    ?>
</body>
</html>