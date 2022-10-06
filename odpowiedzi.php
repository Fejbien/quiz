<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    $pytanie = 'SELECT `id`, `pytanie` FROM `pytania` WHERE id='.$_POST["pytanieID"];
    if($r = $db->query($pytanie)){
        while($row = $r->fetch_assoc()){
            echo "<p>".$row["pytanie"]."</p>";
            
            $odpowiedzi = "SELECT `odpowiedz`, `poprawna` FROM `odpowiedzi` WHERE id_pytania = ".$row["id"].";";
            if($resultsA = $db->query($odpowiedzi)){
                while($rowA = $resultsA->fetch_assoc()){
                    echo "<p>".$rowA["odpowiedz"]."</p>";
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