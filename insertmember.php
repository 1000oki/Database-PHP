<!-- 1910896 통계학과 천옥희
2022-05-18 23:53 -->
<?php
    $conn = mysqli_connect(
        'localhost',
        'root',
        'try1234',
        'library');

    $filtered = array(
    'mnum' => mysqli_real_escape_string($conn, $_POST['StudentNumber']),
    'pword' => mysqli_real_escape_string($conn, $_POST['password']),
    'mname' => mysqli_real_escape_string($conn, $_POST['name']),
    'major' => mysqli_real_escape_string($conn, $_POST['major']),
    'email' => mysqli_real_escape_string($conn, $_POST['email']),
    'birth' => mysqli_real_escape_string($conn, $_POST['birth'])
    );
    $sql = "
        INSERT INTO libraryMember
        (mnum, pword, mname, major, email, birth)
        VALUES(
            '{$filtered['mnum']}',
            '{$filtered['pword']}',
            '{$filtered['mname']}',
            '{$filtered['major']}',
            '{$filtered['email']}',
            '{$filtered['birth']}'
        )
    ";

    $result = mysqli_query($conn, $sql);
    if($result == false){
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
    } else{
        ?>
        <script>
            alert("회원가입이 완료되었습니다");
            location.href = "index.php";
        </script>
        <?php
    }
?>