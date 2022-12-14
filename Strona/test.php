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
        array_push($anserwsGiven, $_POST["anserwIDs"]);
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
        echo "<form action='checkedTest.php' method='POST'>
                <input type='hidden' name='questionsArray' value=".serialize($questionsArray).">
                <input type='hidden' name='anserwsGiven' value=".serialize($anserwsGiven).">
                <input type='submit' value='Zobacz odpowiedzi'>
            </form>";
    }
    else{
        $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionsArray[$questionNumber].";";
        if($resQuestion = $db->query($sqlQuestion)){
            while($rowQuestion = $resQuestion->fetch_assoc()){
                echo "<div class='question'>".$rowQuestion["question"]."</div>";
                echo "<div style='clear: both;'></div>";

                echo "<form action='test.php' method='POST'>
                        <input type='hidden' name='questionsArray' value=".serialize($questionsArray).">
                        <input type='hidden' name='anserwsGiven' value=".serialize($anserwsGiven).">
                        <input type='hidden' name='questionNumber' value=".($questionNumber + 1).">";
    
                $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"].";";
                if($resAnserws = $db->query($sqlAnserws)){
                    while($rowAnserw = $resAnserws->fetch_assoc()){
                        echo "<input type='checkbox' name='anserwIDs[]' value=".$rowAnserw["id"]."><label>".$rowAnserw["anserw"]."</label><br>";      
                    }
                }
                echo "<input type='submit' value='Nastepne pytanie'></form>";
            }
        }
    }
    $db->close();
    ?>
</body>
</html>