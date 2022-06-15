<?php
    $conn = mysqli_connect(
        'localhost',
        'root',
        'try1234',
        'library');

    $bnum = $_POST["bnum"];
    $pword = $_POST["password"];
    $mnum = $_POST["StudentNumber"];
    
    $sql = "SELECT * FROM libraryMember where mnum = '$mnum'";
    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    if(!$result){
        echo "<script>alert('학번이 올바르지 않습니다!');
        history.back();</script>";
      }
    else{
        if($result['pword']==$pword){
            $filtered = array(
                'bnum' => mysqli_real_escape_string($conn, $bnum),
                'mnum' => mysqli_real_escape_string($conn, $mnum)
                );
            $sql2 = "
            INSERT INTO reserve
                (bnum, mnum,reserveDate)
                VALUES(
                    '{$filtered['bnum']}',
                    '{$filtered['mnum']}',
                    NOW()
                )
            ";
            $result2 = mysqli_query($conn, $sql2);

            $sql3 = "
                UPDATE book
                SET
                    reserveState = 1
                WHERE
                    bnum in (SELECT bnum
                            FROM reserve
                            WHERE book.bnum = reserve.bnum
                            and book.bnum = $bnum)
            ";
            mysqli_query($conn, $sql3);
            if($result2 == false){
                echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
            }else{
                echo "<script> alert('예약되었습니다.'); 
                window.close();</script>";
            }
        }else{
            echo "<script>alert('비밀번호가 올바르지 않습니다.');
            history.back();</script>";
        }
      }
?>