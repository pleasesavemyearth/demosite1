<!-- 
  파일명 : memo_regist.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-4
  업데이트일자 : 2022-1-5
  
  기능: 
  글을 작성하고 등록한다.
-->

<?php
// db연결
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

    <form action ="./memo_registprocess.php" method="POST">
    <h1>메모 쓰기</h1> 
    <input hidden type="text" name="username" value="<?=$username?>" />
    제목<input type="text" name="title" required/><br>
    내용<br>
    <input type="text" name="contents" required/><br>

    <input type="submit" value="등록"/>
    <input type="reset"/> 
    <input type="button" value="목록" onclick="location.href='./memo_list.php'"/>
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
    0. 목록을 클릭시 등록과 같은 기능을 수행함, 등록없이 글 목록으로만 와야 함 : button이 아닌 submit 했기 때문
    1. hidden value 에 username ?
    2. label의 기능
    3. 같은 폴더 내에서 이동할 때도 ./ 해줘야 하나 안해도되나 
    4. required 란 입력을 꼭 필요로 함
    5. username을 input hidden type으로 두는 이유 ?
    6. regist와 registprocess에서 username을 입력해줘야 db에 작성자가 반영된다
-->