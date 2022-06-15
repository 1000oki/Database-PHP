<?php
$conn = mysqli_connect(
    'localhost',
    'root',
    'try1234',
    'library');

settype($_GET['Renum'], 'integer');
settype($_GET['bnum'], 'integer');

$filtered = array(
  'renum' => mysqli_real_escape_string($conn, $_GET['Renum']),
  'bnum' => mysqli_real_escape_string($conn, $_GET['bnum'])
);

$sql = "
  DELETE 
  FROM reserve
  where Renum = {$filtered['renum']}
";

mysqli_query($conn, $sql);

$sql2 = "
    UPDATE book, reserve
        SET reserveState = 0
        where book.bnum = {$filtered['bnum']}
        and not exists (select Renum
                          from reserve
                          where reserve.bnum = {$filtered['bnum']}
                          and reserve.bnum = book.bnum
                          and reserve.rnum is null)
    ";

$result = mysqli_query($conn, $sql2);
if($result == false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else{
    echo '삭제에 성공했습니다.<a href="index.php">돌아가기</a>';
}

?>