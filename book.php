<!-- 1910896 통계학과 천옥희 -->
<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  'try1234',
  'library');

  $sql = "SELECT * FROM book";
  $result = mysqli_query($conn, $sql);
  $table = '';
  while($row = mysqli_fetch_array($result)){
    if($row['reserveState'] == 0 && $row['rentState']==0){
        $state = "대출가능";
    }else if($row['rentState']==1){
        $state = "대출중";
    }else if($row['reserveState'] == 1 && $row['rentState']==0){
        $state = "예약중";
    }
    $table = $table."<tr><td>{$row['bnum']}</td>
                    <td>{$row['bname']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['publisher']}</td>
                    <td>{$row['bookyear']}</td>
                    <td>{$state}</td></tr>";
  }

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>BOOK</title>  
        <link href="https://fonts.googleapis.com/css2?family=Gowun+Batang&display=swap" rel="stylesheet">
        <style type = "text/css">
            body{background-color: #DAE3F3;font-family: "Gowun Batang"; font-size:17px;}
            h1{margin-top : 80px; font-size: 30pt; font-family: "Gowun Batang";}
            hr{margin-left: 100px; margin-right: 100px; margin-top : 30px}
            .small_title{margin-top: 80px;}
            a{margin : 150px; font-family: "Gowun Batang"; font-size: 23px; font-weight: bold;}
            a:link{color:'black'}
            a:hover{color:rgba(192, 192, 192, 0.327);}
            a:visited{color:rgba(128, 128, 128, 0.388)}
            .join {width: 100%; height: 300px; border: 1px solid #000;}
            div.left {width: 30%;float: left;box-sizing: border-box; margin-left: 100px; }
            div.right {width: 55%; float: right; box-sizing: border-box; margin-right:100px; }
            h3{text-align: center; font-weight: bold;}
            table{text-align: center; margin-top : 30px;}
        </style>
    </head>
    <body>
        <center>
        <h1 style = "color :#708090 "><img src="Home.png" width="50" height="50">  눈송이 도서관</h1>
        <div id = "small_title">
            <pre id ="link"><a href = "index.php">회원가입</a><a href = "book.php">도서</a><a href = "rent.php">대여</a></pre>
        </div>
        <hr>
        <div id="join">
            <div class="left">
            <h3>도서 추가</h3>
            <form action="insertbook.php" method="POST">
                <p>도서번호 : <input type = "number" name="booknumber"/></p> 
                <p>도서이름 : <input type = "text" name="bookname"/></p> 
                <p>작가 : <input type = "text" name="author"/></p>
                <p>출판사 : <input type = "text" name="publisher"/> </p>
                <p>출판년도 : <input type = "date" name="year"/></p>
                <p><input type="hidden" value='0' name="rentState"/>
                <p><input type="hidden" value='0' name="reserveState"/>
                <input type="submit" value="추가"/>
            </form>
            </div>
            <div class="right">
                <h3>도서 내역</h3>
                <table width="500" border="2" align="center">
                    <th>도서번호</th>
                    <th>도서이름</th>
                    <th>작가</th>
                    <th>출판사</th>
                    <th>출판년도</th>
                    <th>대출여부</th>
                    <?=$table?>
                </table>    
            </div>
        </div>
        </center>
    </body>
</html>
