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
    $questionID = $_POST["questionID"];
    $anserwID = $_POST["anserwID"];
    $correctAnserwID = [];

    // Wypisuje pytanie i odpowiedzi zaznaczajac czy jest poprawna czy tez i nie
    $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionID.";";
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

    // Przydziela wynik
    if(in_array($anserwID, $correctAnserwID)){
        $db->query("UPDATE `users` SET `right`=`right`+1 WHERE id = ".$_COOKIE["userID"].";");
    }else{
        $db->query("UPDATE `users` SET `wrong`=`wrong`+1 WHERE id = ".$_COOKIE["userID"].";");
    }
    
    echo "<form action='test.php' method='POST'>
            <input type='hidden' name='questionsArray' value=".$_POST["questionsArray"].">
            <input type='hidden' name='questionNumber' value=".($_POST["questionNumber"]+1).">
            <input class='next' type='submit' value='Nastepne pytanie'>
        </form>";

    $db->close();
    ?>
</body>
</html>