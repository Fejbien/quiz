<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    $questionID = trim($_POST["questionID"], "/");
    $anserwID = trim($_POST["anserwID"], "/");

    $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionID.";";
    if($resQuestion = $db->query($sqlQuestion)){
        while($rowQuestion = $resQuestion->fetch_assoc()){
            echo "<div class='question'>".$rowQuestion["question"]."</div>";

            $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"];
            if($resAnserws = $db->query($sqlAnserws)){
                while($rowAnserw = $resAnserws->fetch_assoc()){
                    if($rowAnserw["is_correct"] != null){
                        echo "<div class='anserws' style='background-color: green;'>".$rowAnserw["anserw"]."</div>";
                    }
                    else if($rowAnserw["id"] == $anserwID){
                        echo "<div class='anserws' style='background-color: red;'>".$rowAnserw["anserw"]."</div>";
                    }
                    else{
                        echo "<div class='anserws'>".$rowAnserw["anserw"]."</div>";
                    }
                }
            }
        }
    }
    echo "<a href='question.php'><div class='next'>Losowe pytanie</div></a>";
    
    $db->close();
    ?>
</body>
</html>