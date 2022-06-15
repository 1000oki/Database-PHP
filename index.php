<!-- 1910896 통계학과 천옥희 -->

<?php
    $conn = mysqli_connect(
        'localhost',
        'root',
        'try1234',
        'library');
    
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>  
        <link href="https://fonts.googleapis.com/css2?family=Gowun+Batang&display=swap" rel="stylesheet">
        <style type = "text/css">
            body{background-color: #DAE3F3; font-family: "Gowun Batang"; font-size:17px;}
            h1{margin-top : 80px; font-size: 30pt; font-family: "Gowun Batang";}
            hr{margin-left: 100px; margin-right: 100px; margin-top : 30px}
            .small_title{margin-top: 80px; font-family: "Gowun Batang";}
            a{margin : 150px; font-family: "Gowun Batang"; font-size: 23px; font-weight: bold;}
            a:link{color:black;}
            a:hover{color:rgba(192, 192, 192, 0.327);}
            a:visited{color:rgba(128, 128, 128, 0.388)}
            
        </style>
    </head>
    <body>
        <center>
        <h1 style = "color :#708090 "><img src="Home.png" width="50" height="50">  눈송이 도서관</h1>
        <div id = "small_title">
            <pre><a href = "index.php">회원가입</a><a href = "book.php">도서</a><a href = "rent.php">대여</a></pre>
        </div>
        <hr>
        <div id="join">
            <h3>회원가입</h3>
            <form action="insertmember.php" method="POST">
                <p>학과 : <input type = "text" name="major"/></p> 
                <p>이름 : <input type = "text" name="name"/></p>
                <p>학번 : <input type = "number" name="StudentNumber" id="mnum"/> </p>
                <p><span id = "checknum" style='color:red;'>학번 중복 여부를 확인해주세요!  </span><input type="button" value="중복 검사" onclick="checknumber()"/></p>
                <p>비밀번호 : <input type = "password" name="password" id="password"/></p>
                <p>비밀번호 확인 : <input type = "password" name="password2" id="password2" oninput="checkpw()"/></p>
                <p id="passwordresult"></p>
                <p>이메일 : <input type = "email" name="email"/></p>
                <p>생년월일 : <input type = "date" name="birth"/></p>
                <input type="submit" id="submit" value="회원가입" >
            </form>
        </center>
            <script type = "text/javascript">                
                function checkpw(){
                    var p1 = document.getElementById("password").value;
                    var p2 = document.getElementById("password2").value;
                    var result = document.getElementById("passwordresult");
                    if(p1 != p2){
                        result.innerHTML = "비밀번호가 다릅니다.";
                        result.style.color = 'red';
                        document.getElementById("submit").disabled = true;
                    }else{
                        result.innerHTML = "비밀번호가 일치합니다.";
                        result.style.color = 'blue';
                        document.getElementById("submit").disabled = false;
                    }
                }

                function checknumber(){
                    var mnum = document.getElementById("mnum").value;
                    if(mnum){
                        url = "checknumber.php?mnum="+mnum;
                        window.open(url,"chknumber","width=300, height=100");
                    }else{
                        alert("학번을 입력하세요");
                    }
                }

                function success(){
                    document.getElementById("checknum").innerHTML="사용 가능한 학번입니다!  ";
                    document.getElementById("checknum").style.color = 'blue';
                    document.getElementById("submit").disabled = false;
                }
                function fail(){
                    document.getElementById("checknum").innerHTML="이미 가입된 학번입니다.!  ";
                    document.getElementById("checknum").style.color = 'red';
                    document.getElementById("submit").disabled = true;
                }
            </script>
        </div>
    </body>
</html>
