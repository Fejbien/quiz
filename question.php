<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    $max = $db->query("SELECT COUNT(`id`) as `max` FROM `questions` WHERE 1;")->fetch_assoc()["max"];
    $randQuestion = rand(1, $max);

    $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$randQuestion.";";
    if($resQuestion = $db->query($sqlQuestion)){
        while($rowQuestion = $resQuestion->fetch_assoc()){
            echo "<div class='question'>".$rowQuestion["question"]."</div>";
            echo "<div style='clear: both;'></div>";

            $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"].";";
            if($resAnserws = $db->query($sqlAnserws)){
                while($rowAnserw = $resAnserws->fetch_assoc()){
                    echo "<form action='checked.php' method='POST'>";
                    echo "<input type='hidden' name='questionID' value=".$rowQuestion["id"]."/>";
                    echo "<input type='hidden' name='anserwID' value=".$rowAnserw["id"]."/>";
                    echo "<input type='submit' value='".$rowAnserw["anserw"]."'/>";
                    echo "</form>";
                }
            }
        }
    }
    $db->close();
    ?>
</body>
</html>