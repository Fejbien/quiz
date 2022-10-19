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
    $anserwIDs = $_POST["anserwIDs"];
    $correctAnserwID = [];

	print_r($anserwIDs);

    $sqlQuestion = "SELECT `id`, `question` FROM `questions` WHERE id = ".$questionID.";";
    if($resQuestion = $db->query($sqlQuestion)){
        while($rowQuestion = $resQuestion->fetch_assoc()){
            echo "<div class='question'>".$rowQuestion["question"]."</div>";

            $sqlAnserws = "SELECT `id`, `anserw`, `is_correct` FROM `anserws` WHERE `question_id` = ".$rowQuestion["id"];
            if($resAnserws = $db->query($sqlAnserws)){
                while($rowAnserw = $resAnserws->fetch_assoc()){
                    if($rowAnserw["is_correct"] != null){
						if(in_array($rowAnserw["id"], $anserwIDs)){
							echo "<div class='anserws' style='background-color: blue;'>".$rowAnserw["anserw"]."</div>";
						}
						else{
							echo "<div class='anserws' style='background-color: green;'>".$rowAnserw["anserw"]."</div>";
						}
                        array_push($correctAnserwID, $rowAnserw["id"]);
                    }
                    else if(in_array($rowAnserw["id"], $anserwIDs)){
                        echo "<div class='anserws' style='background-color: red;'>".$rowAnserw["anserw"]."</div>";
                    }
                    else{
                        echo "<div class='anserws'>".$rowAnserw["anserw"]."</div>";
                    }
                }
            }
        }
    }

	for($i = 0; $i < count($anserwIDs); $i++){
		if(in_array($anserwIDs[$i], $correctAnserwID)){
			$db->query("UPDATE `users` SET `right`=`right`+1 WHERE id = ".$_COOKIE["userID"].";");
		}else{
			$db->query("UPDATE `users` SET `wrong`=`wrong`+1 WHERE id = ".$_COOKIE["userID"].";");
		}
	}
    
    echo "<form action='question.php' method='POST'>
            <input class='next' type='submit' value='Losowe pytanie'>
        </form>";

    $db->close();
    ?>
</body>
</html>