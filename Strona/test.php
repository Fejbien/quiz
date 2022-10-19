<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $questionsCount=5;
    if(empty($_COOKIE["userID"]))
        header('Location: index.php');
    
    include "Elements/menuGenerator.php";

    $db = new mysqli("localhost", "root", "", "quiz");
    
    $max = $db->query("SELECT COUNT(`id`) as `max` FROM `questions` WHERE 1;")->fetch_assoc()["max"];
    $anserwsGiven = [];
    $questionsArray = [];
    $questionNumber = 0;

    if(isset($_POST["questionsArray"]) && isset($_POST["questionNumber"]) && isset($_POST["anserwsGiven"])){
        $questionsArray = unserialize($_POST["questionsArray"]);
        $questionNumber = $_POST["questionNumber"];
        $anserwsGiven = unserialize($_POST["anserwsGiven"]);
        array_push($anserwsGiven, $_POST["anserwID"]);
    }
    else{
        while(count($questionsArray) < $questionsCount){
            $randQuestion = rand(1, $max);
            if(!in_array($randQuestion, $questionsArray)){
                array_push($questionsArray, $randQuestion);
            }
        }
        $questionNumber = 0;
    }

    if($questionNumber >= $questionsCount){
        echo "ZOBACZ ODPOWIEDZI";
        
        print_r($questionsArray);
        print_r($anserwsGiven);
    }
    else{
        // Wypisuje wylosowane pytania i kazda odpowiedz to przycisk ktory kieruje na strone sprawdzajaca podana odpowiedz
        // Pieknie to wyglada
        $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionsArray[$questionNumber].";";
        if($resQuestion = $db->query($sqlQuestion)){
            while($rowQuestion = $resQuestion->fetch_assoc()){
                echo "<div class='question'>".$rowQuestion["question"]."</div>";
                echo "<div style='clear: both;'></div>";

                $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"].";";
                if($resAnserws = $db->query($sqlAnserws)){
                    while($rowAnserw = $resAnserws->fetch_assoc()){
                        echo "<form action='test.php' method='POST'>
                                <input type='hidden' name='questionsArray' value=".serialize($questionsArray).">
                                <input type='hidden' name='anserwsGiven' value=".serialize($anserwsGiven).">
                                <input type='hidden' name='questionNumber' value=".($questionNumber + 1).">
                                <input type='hidden' name='questionID' value=".$rowQuestion["id"].">
                                <input type='hidden' name='anserwID' value=".$rowAnserw["id"].">
                                <input type='submit' value='".$rowAnserw["anserw"]."'>
                            </form>";
                    }
                }
            }
        }
    }
    $db->close();
    ?>
</body>
</html>