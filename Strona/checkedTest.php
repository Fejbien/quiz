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

    $questionsArray = unserialize($_POST["questionsArray"]);
    $anserwsGiven = unserialize($_POST["anserwsGiven"]);

    $correctAnserwID = [];
    
    $maxPoints = 0;
    $wrong = 0;
    $pointsCount = 0;

    for($i = 0; $i < count($questionsArray); $i++){
        $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionsArray[$i].";";
        if($resQuestion = $db->query($sqlQuestion)){
            while($rowQuestion = $resQuestion->fetch_assoc()){
                echo "<div class='question'>".$rowQuestion["question"]."</div>";

                $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"];
                if($resAnserws = $db->query($sqlAnserws)){
                    while($rowAnserw = $resAnserws->fetch_assoc()){
                        if($rowAnserw["is_correct"] != null){
                            $maxPoints++;
                            if(in_array($rowAnserw["id"], $anserwsGiven[$i])){
                                echo "<div class='anserws' style='background-color: blue;'>".$rowAnserw["anserw"]."</div>";
                                $pointsCount++;
                            }
                            else{
                                echo "<div class='anserws' style='background-color: green;'>".$rowAnserw["anserw"]."</div>";
                            }
                            array_push($correctAnserwID, $rowAnserw["id"]);
                        }
                        else if(in_array($rowAnserw["id"], $anserwsGiven[$i])){
                            echo "<div class='anserws' style='background-color: red;'>".$rowAnserw["anserw"]."</div>";
                            $wrong++;
                        }
                        else{
                            echo "<div class='anserws'>".$rowAnserw["anserw"]."</div>";
                        }
                    }
                }
            }
        }
        echo "<br><br>";
    }

    echo "<p style='margin: 10px auto 10px auto; text-align: center; font-size: 200%; font-weight: bold;'>
            Punkty ".($pointsCount - $wrong > 0 ? $pointsCount - $wrong : 0)." na $maxPoints
        </p>";
    
    echo "<form action='index.php' method='POST'>
            <input class='next' type='submit' value='Powrot'>
        </form>";

    $db->close();
    ?>
</body>
</html>