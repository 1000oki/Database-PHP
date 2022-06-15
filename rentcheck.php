<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  'try1234',
  'library');

  $bnum = $_GET["bnum"];
  ?>
<!doctype html>
<html>
    <head>
    </head>
    <body>
        <form method="POST" action ="bookupdate.php">
            <p>도서 번호 : <input type = "text" name="bnum" value='<?= $bnum?>' readonly/></p> 
            <p>학번 : <input type = "number" name="StudentNumber"/> </p>
            <p>비밀번호 : <input type = "password" name="password"/></p>
            <input type="submit" value ="대출하기">
        </form>
    </body>
</html>