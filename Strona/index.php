<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>QUIZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = new mysqli("localhost", "root", "", "quiz");

    // Nie zalogowany
    if(!isset($_COOKIE["userID"])){
        $sql = "SELECT `id`, `name` FROM `users` WHERE 1;";
        if($res = $db->query($sql)){
            while($row = $res->fetch_assoc()){
                echo "<form action='logIn.php' method='POST'>
                        <input type='hidden' name='userID' value=".$row["id"].">
                        <input type='submit' value='".$row["name"]."'>
                    </form>";
            }
        }
    }
    // Zalogowany
    else{
        $sql = "SELECT `id`, `name`, `right`, `wrong` FROM `users` WHERE id = ".$_COOKIE["userID"].";";
        $row = $db->query($sql)->fetch_assoc();
        echo "<div class='info'>
                <h1>Zalogowano jako: ".$row["name"]."</h1>
                <p>Udzielone odpowiedzi: ".($row["right"] + $row["wrong"])."</p>
                <p>Poprawne odpowiedzi: ".$row["right"]."</p>
                <p><span style='color: red;'>Nie</span> poprawne odpowiedzi: ".$row["wrong"]."</p>

                <form action='logOut.php' method='POST'>
                    <input type='submit' value='WYLOGUJ SIE!'>
                </form>
                <form action='question.php' method='POST'>
                    <input class='next' type='submit' value='Losowe pytanie'>
                </form>

                <form action='test.php' method='POST'>
                    <input class='next' type='submit' value='Zrob losowy test!'>
                </form>
            </div>";
    }

    $db->close();
    ?>
</body>
</html>
