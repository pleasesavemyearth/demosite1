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
    <form action ="./border_registprocess.php" method="POST">
    <h1>글쓰기</h1> 
    <input hidden type="text" name="username" value="<?=$username?>" />
    제목<input type="text" name="title" required/><br>
    내용<br>
    <input type="text" name="contents" required/><br>

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