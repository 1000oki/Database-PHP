<!-- 1910896 통계학과 천옥희
2022-05-18 23:53 -->
<?php
    $conn = mysqli_connect(
        'localhost',
        'root',
        'try1234',
        'library');

    $filtered = array(
        'bnum' => mysqli_real_escape_string($conn, $_POST['booknumber']),
        'bname' => mysqli_real_escape_string($conn, $_POST['bookname']),
        'author' => mysqli_real_escape_string($conn, $_POST['author']),
        'publisher' => mysqli_real_escape_string($conn, $_POST['publisher']),
        'bookyear' => mysqli_real_escape_string($conn, $_POST['year']),
        'rentState'=> mysqli_real_escape_string($conn, $_POST['rentState']),
        'reserveState'=> mysqli_real_escape_string($conn, $_POST['reserveState'])
    );
    $sql = "
        INSERT INTO Book
        (bnum, bname, author, publisher, bookyear,rentState, reserveState)
        VALUES(
            '{$filtered['bnum']}',
            '{$filtered['bname']}',
            '{$filtered['author']}',
            '{$filtered['publisher']}',
            '{$filtered['bookyear']}',
            '{$filtered['rentState']}',
            '{$filtered['reserveState']}'
        )
    ";

    $result = mysqli_query($conn, $sql);
    if($result == false){
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
    } else{
        ?>
        <script>
            alert("도서가 추가되었습니다.");
            location.href = "book.php";
        </script>
        <?php
    }
?>