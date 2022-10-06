<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");
    $pytania = "SELECT `id`, `pytanie` FROM `pytania` WHERE 1;";
    if($results = $db->query($pytania)){
        while($row = $results->fetch_assoc()){
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