<?php
$conn = mysqli_connect(
    'localhost',
    'root',
    'try1234',
    'library');

$rnum = $_GET['rnum'];
$sql = "
UPDATE rent
SET
  returnState = 1
WHERE
  rnum = '{$rnum}'
";

$sql1 = "
UPDATE book, rent
SET rentState = 0  
WHERE rnum = '{$rnum}'
AND book.bnum = rent.bnum
";

$result = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql1);
if($result == false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
}else if ($result1 == false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
}else{
    echo "<script> alert('반납되었습니다.'); 
    window.close();</script>";
}
?>