<!-- 
  파일명 : border_regist.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  글을 작성하고 등록한다.
-->

<?php
require "../util/dbconfig.php";
require_once "../util/loginchk.php";

if($chk_login) {
    $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action ="./border_registprocess.php" method="POST" enctype="multipart/form-data">
    <h1>글쓰기</h1> 
    <input hidden type="text" name="username" value="<?=$username?>" />
    제목<input type="text" name="title" required/><br>
    내용<br>
    <input type="text" name="contents" required/><br>

    <input type="file" name="uploadfile" /><br><br>

    <input type="submit" value="등록"/>
    <input type="reset"/> 
    <input type="button" value="목록" onclick="location.href='./border_list.php'"/>
    </form>

</body>
<?php
} else {
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
  }
?>
</html>
<!-- 
  img db에 업로드 하는 방법
  1. type이 file인 input태그 추가
  2. db에서 image라는 column 추가(data type: varchar(100))
  3. 

  enctype="multipart/form-data" : post방식에서 데이터를 전송하는 용량보다 더 큰 용량을 전송할 수 있게 함
-->