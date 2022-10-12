<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    // UPDATE `users` SET `right`=`right`+1 WHERE id = userID;
    // UPDATE `users` SET `wrong`=`wrong`+1 WHERE id = userID;
    
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    $sql = "SELECT `id`, `name` FROM `users` WHERE 1;";
    if($res = $db->query($sql)){
        while($row = $res->fetch_assoc()){
            echo "<form action='question.php' method='POST'>";
            echo "<input type='hidden' name='userID' value=".$row["id"]."/>";
            echo "<input type='submit' value='".$row["name"]."'/>";
            echo "</form>";
        }
    }
    ?>
</body>
</html>
