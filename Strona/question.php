<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if(empty($_COOKIE["userID"]))
        header('Location: index.php');
    
    include "Elements/menuGenerator.php";

    $db = new mysqli("localhost", "root", "", "quiz");
    
    $max = $db->query("SELECT COUNT(`id`) as `max` FROM `questions` WHERE 1;")->fetch_assoc()["max"];
    $randQuestion = rand(1, $max);

    // Wypisuje wylosowane pytania i kazda odpowiedz to przycisk ktory kieruje na strone sprawdzajaca podana odpowiedz
    $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$randQuestion.";";
    if($resQuestion = $db->query($sqlQuestion)){
        while($rowQuestion = $resQuestion->fetch_assoc()){
            echo "<div class='question'>".$rowQuestion["question"]."</div>";
            echo "<div style='clear: both;'></div>";

            $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"].";";
            if($resAnserws = $db->query($sqlAnserws)){
                while($rowAnserw = $resAnserws->fetch_assoc()){
                    echo "<form action='checked.php' method='POST'>
                            <input type='hidden' name='questionID' value=".$rowQuestion["id"].">
                            <input type='hidden' name='anserwID' value=".$rowAnserw["id"].">
                            <input type='submit' value='".$rowAnserw["anserw"]."'>
                        </form>";
                }
            }
        }
    }
    $db->close();
    ?>
</body>
</html>