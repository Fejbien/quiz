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

    for($i = 0; $i < count($questionsArray); $i++){
        $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionsArray[$i].";";
        if($resQuestion = $db->query($sqlQuestion)){
            while($rowQuestion = $resQuestion->fetch_assoc()){
                echo "<div class='question'>".$rowQuestion["question"]."</div>";

                $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"];
                if($resAnserws = $db->query($sqlAnserws)){
                    while($rowAnserw = $resAnserws->fetch_assoc()){
                        if($rowAnserw["is_correct"] != null){
                            array_push($correctAnserwID, $rowAnserw["id"]);
                            echo "<div class='anserws' style='background-color: green;'>".$rowAnserw["anserw"]."</div>";
                        }
                        else if($rowAnserw["id"] == $anserwsGiven[$i]){
                            echo "<div class='anserws' style='background-color: red;'>".$rowAnserw["anserw"]."</div>";
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

    $correctCount = 0;
    for($i = 0; $i < count($anserwsGiven); $i++){
        if(in_array($anserwsGiven[$i], $correctAnserwID))
            $correctCount++;
    }

    echo "<p style='margin: 10px auto 10px auto; text-align: center; font-size: 200%; font-weight: bold;'>
            Ilosc podanych poprawynych odpowedzi to: $correctCount
        </p>";
    
    echo "<form action='index.php' method='POST'>
            <input class='next' type='submit' value='Powrot'>
        </form>";

    $db->close();
    ?>
</body>
</html>