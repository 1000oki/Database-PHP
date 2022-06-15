<!-- 1910896 통계학과 천옥희 -->
<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  'try1234',
  'library');

  $bname = $_POST["bookname"];
  $sql = "SELECT * FROM book where bname = '$bname'";
  $result = mysqli_query($conn, $sql);
  $table = '';
  $num = 0;
  $rum = 0;
  while($row = mysqli_fetch_array($result)){
    if($row['rentState'] == 0 && $row['reserveState']==0){
        $num = $row['bnum'];
        $state = "<input type='button' value='대출하기' onclick='rent()'/>";
    }else{
        $num = $row['bnum'];
        $state = "<input type='button' value='예약하기' onclick='reserve()'/>";
    }
    $rank = "<input type='button' value='순위보기' onclick='rank()'/>";
    $rum = $row['bnum'];
    $table = $table."<tr><td>{$row['bnum']}</td>
                    <td>{$row['bname']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['publisher']}</td>
                    <td>{$row['bookyear']}</td>
                    <td>{$state}</td>
                    <td>{$rank}</td></tr>";
  }

  settype($_POST['mnum'], 'integer');

  $filtered = array(
    'mnum' => mysqli_real_escape_string($conn, $_POST['mnum']),
    'pword' => mysqli_real_escape_string($conn, $_POST['pword'])
  );

  $sql2 = "
        SELECT rnum, book.bnum, bname, author, publisher, rentDate, returnDate, returnState
          FROM book, rent, librarymember
          WHERE librarymember.mnum = '{$filtered['mnum']}'
          AND librarymember.pword ='{$filtered['pword']}'
          AND rent.mnum = librarymember.mnum
          AND book.bnum = rent.bnum
          ";
          

$result2 = mysqli_query($conn, $sql2);
$table2 = '';
while($row = mysqli_fetch_array($result2)){
     if($row['returnState']==0){
         $num = $row['rnum'];
         $state = "<input type='button' value='반납하기' onclick = 'turn()'/>";
     }else{
         $state = "<span style='color:red;'>반납완료</span>";
     }
    $table2 = $table2."<tr><td>{$row['bnum']}</td>
                    <td>{$row['bname']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['publisher']}</td>
                    <td>{$row['rentDate']}</td>
                    <td>{$row['returnDate']}</td>
                    <td>{$state}</td></tr>";
  }

  $sql3 = "
    SELECT reserve.Renum, book.bnum, bname, author, publisher, reserveDate, rentDate 
    FROM reserve
    left join rent
        on reserve.mnum = rent.mnum
        and reserve.rnum = rent.rnum
    left join book
        on reserve.bnum = book.bnum 
    INNER JOIN librarymember
        on reserve.mnum = librarymember.mnum
        and librarymember.mnum = '{$filtered['mnum']}'
        and librarymember.pword ='{$filtered['pword']}'
  ";
  

    $result3 = mysqli_query($conn, $sql3);
    $renum = 0;
    $bnum = 0;
    while($row = mysqli_fetch_array($result3)){
        if($row['rentDate']==null){
            $renum = $row['Renum'];
            $bnum = $row['bnum'];
            $button = "<input type='button' value='예약취소' onclick='deletes()'/>";
        }else{
            $button = "대출완료";
        }
        $table3 = $table3."<tr><td>{$row['bnum']}</td>
            <td>{$row['bname']}</td>
            <td>{$row['author']}</td>
            <td>{$row['publisher']}</td>
            <td>{$row['reserveDate']}</td>
            <td>{$row['rentDate']}</td>
            <td>{$button}</td></tr>";
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RENT</title>  
        <link href="https://fonts.googleapis.com/css2?family=Gowun+Batang&display=swap" rel="stylesheet">
        <style type = "text/css">
            body{background-color: #DAE3F3;font-family:"Gowun Batang"; font-size:17px;}
            h1{margin-top : 80px; font-size: 30pt; font-family: "Gowun Batang";}
            hr{margin-left: 100px; margin-right: 100px; margin-top : 30px}
            .small_title{margin-top: 80px;}
            a{margin : 150px; font-family: "Gowun Batang"; font-size: 23px; font-weight: bold;}
            a:link{color:black;}
            a:hover{color:rgba(192, 192, 192, 0.327);}
            a:visited{color:rgba(128, 128, 128, 0.388)}
            .join {width: 100%; height: 300px; border: 1px solid #000;}
            div.left {width: 40%;float: left;box-sizing: border-box; margin-left: 50px; }
            div.right {width: 50%; float: right; box-sizing: border-box; margin-right:50px; }
            h3{text-align: center; font-weight: bold;}
            .join{position:absolute; top:50px}
            table{font-size:15px}
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
            <h3>책 검색</h3>
                <form method="POST">    
                    <p>책 이름 : <input type = "text" name="bookname"/> 
                    <input type="submit" value="검색" /></p>
                </form>

                <table id="book" width="480" border="2" align="center">
                    <th>도서번호</th>
                    <th>도서이름</th>
                    <th>작가</th>
                    <th>출판사</th>
                    <th>출판년도</th>
                    <th>대출여부</th>
                    <th>예약순위</th>
                    <?=$table?>
                </table>
            </div>
            <div class="right">
            <h3>나의 도서 내역 보기</h3>
                <form method="POST">    
                    <p>학번 : <input type = "text" name="mnum"/>
                    <p>비밀번호 : <input type = "password" name="pword"/></p>  
                    <p><input type="submit" value="검색" /></p>
                </form>

                <대출 내역>
                <table border="2 "width="600" align="center">
                    <th>도서번호</th>
                    <th>도서이름</th>
                    <th>작가</th>
                    <th>출판사</th>
                    <th>대출일</th>
                    <th>반납일</th>
                    <th>반납</th>
                    <?=$table2?>
                </table>

                <예약 내역>
                <table border="2 "width="660" align="center">
                    <th>도서번호</th>
                    <th>도서이름</th>
                    <th>작가</th>
                    <th>출판사</th>
                    <th>예약일</th>
                    <th>대출일</th>
                    <th>예약취소</th>
                    <?=$table3?>
                </table>
            </div>
            
        </div>
        </center>
        <script type = "text/javascript">
            function rent(){
                    url = "rentcheck.php?bnum="+<?=$num?>;
                    window.open(url,"rent","width=500, height=200");
                    
                }

            function reserve(){
                    url = "reservecheck.php?bnum="+<?=$num?>;
                    window.open(url,"reserve","width=500, height=200");
                    
                }
            
            function turn(){
                    url = "return.php?rnum="+<?=$num?>;
                    window.open(url,"return","width=500, height=200");
            }

            function rank(){
                    url = "rank.php?bnum="+<?=$rum?>;
                    window.open(url,"rank","width=500, height=200");
            }

            function deletes(){
                    url = "delete.php?Renum="+<?=$renum?>+"&bnum = "+<?=$bnum?>;
                    window.open(url,"renum","width=500, height=200");
            }
        </script>         
    </body>
</html>