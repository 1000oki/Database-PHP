<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  'try1234',
  'library');

  $bnum = $_GET["bnum"];
  $mnum = $_GET['mnum'];
  $pword = $_POST["password"];
  $time_now = date("Y-m-d");
  $returndate = date("Y-m-d", strtotime($returndate."10 days"));

  $sql = "SELECT * FROM libraryMember where mnum = '$mnum'";
  $result = mysqli_fetch_array(mysqli_query($conn, $sql));


    if($result['pword']==$pword && $pword != null){
        $filtered = array(
            'bnum' => mysqli_real_escape_string($conn, $bnum),
            'mnum' => mysqli_real_escape_string($conn, $mnum)
            );
        $sql2 = "
        INSERT INTO rent
            (bnum, mnum, rentDate, returnDate, returnState)
            VALUES(
                '{$filtered['bnum']}',
                '{$filtered['mnum']}',
                NOW(),
                '{$returndate}',
                '0'
            )
        ";
        mysqli_query($conn, $sql2);
        $sql3 = "
            UPDATE book
            SET
                rentState = 1
            WHERE
                bnum = $bnum
        ";
        mysqli_query($conn, $sql3);

        $sql4 = "
            UPDATE reserve, rent
            SET reserve.rnum= rent.rnum
            WHERE rent.mnum = $mnum
            AND rent.bnum = $bnum
            AND rent.returnState = 0
            AND reserve.bnum = rent.bnum
			AND reserve.mnum = rent.mnum
            AND reserve.rnum is null
            ";
        mysqli_query($conn, $sql4);
        $sql5 = "
        UPDATE book, reserve
        SET reserveState = 0
        where book.bnum = $bnum
        and not exists (select Renum
                          from reserve
                          where reserve.bnum = $bnum
                          and reserve.bnum = book.bnum
                          and reserve.rnum is null)      
        ";
        $result2 = mysqli_query($conn, $sql5); 
        if($result2 == false){
            echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        }else{
            echo "<script> alert('대출되었습니다.'); 
            window.close();</script>";
        }
    }else if($pword != null){
        echo "<script>alert('비밀번호가 올바르지 않습니다.');
        history.back();</script>";
    }
  

  ?>
<!doctype html>
<html>
    <head>
    </head>
    <body>
        <form method="POST">
            <p>비밀번호 : <input type = "password" name="password"/></p>
            <input type="submit" value ="대출하기">
        </form>
    </body>
</html>