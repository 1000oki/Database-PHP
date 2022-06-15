<!-- 1910896 통계학과 천옥희
2022-05-18 23:53 -->

<?php
    $conn = mysqli_connect(
        'localhost',
        'root',
        'try1234',
        'library'
    );

    $mnum = $_GET["mnum"];
    $sql = "SELECT * FROM libraryMember where mnum = '$mnum'";
    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    if(!$result){
        echo "<span style='color : blue;'>$mnum 은 사용 가능한 학번입니다.</span>";
        ?><p><input type=button value="확인" onclick="opener.parent.success(); window.close();"></p>
    <?php  
    } else{
        echo "<span style='color : red;'>$mnum 은 이미 가입된 학번입니다.</span>";
        ?><p><input type=button value="확인" onclick="opener.parent.fail(); window.close();"></p>
    <?php    
    }
?>


