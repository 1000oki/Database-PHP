<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  'try1234',
  'library');

  $bnum = $_GET["bnum"];

  $sql = "
    select mnum, book.bnum, rentState,rank() over(order by Renum) As ranking
    from reserve, book
    where reserve.bnum = $bnum
    and reserve.bnum = book.bnum
    and rnum is null
    ";

    $result = mysqli_query($conn, $sql);
    $num = 0;
    $studentnum = 0;
    while($row = mysqli_fetch_array($result)){
        $rent = '' ;
        if($row['rentState'] == 0 && $row['ranking'] == 1){
            $studentnum = $row['mnum'];
            $rent = "<input type='button' value='대출하기' onclick='reserverent()'/>";
        }else{
            $rent = "<span style='color:blue;'>대기중</span>";
        }
        $table = $table."<tr><td>{$row['mnum']}</td>
                    <td>{$row['ranking']}</td>
                    <td>{$rent}</td></tr>";
    }
  ?>
  <!doctype html>
<html>
    <head>
    </head>
    <body>
        <table border="2 "width="300" align="center">
            <th>학번</th>
            <th>도서 예약 순위</th>
            <th>대출</th>
            <?=$table?>
        </table>
        <p id='s'></p>
        <script type = "text/javascript">
            function reserverent(){
                url = "reserverent.php?bnum="+<?=$bnum?>+"&mnum="+<?=$studentnum?>;
                window.open(url,"reserve","width=500, height=200");  
            }
        </script>     
    </body>
</html>