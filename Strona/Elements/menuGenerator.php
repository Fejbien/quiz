<?php
$db = new mysqli("localhost", "root", "", "quiz");

$menuSql = "SELECT `id`, `name`, `right`, `wrong` FROM `users` WHERE id=".$_COOKIE["userID"].";";
$menuData = $db->query($menuSql)->fetch_assoc();

echo "
<div class='menu'>
    <table><tr>
        <td><h1><a href='index.php'>Strona</a></h1></td>
        <td><h1>Zalogowano: ".$menuData["name"]."</h1></td>
        <td><h1>".($menuData["right"]+$menuData["wrong"])."/".$menuData["right"]."</h1></td>
    </tr></table>
</div>";

$db->close();
?>