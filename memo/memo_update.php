<!-- 
  파일명 : memo_update.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 memo데이터를 수정폼으로 불러온다.
-->

<?php
require '../util/dbconfig.php';

$id = $_GET['id'];
$sql = "SELECT * FROM memo WHERE id = ".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_array();
  $username = $row['username'];
  $title = $row['title'];
  $contents = $row['contents'];
  $regtime = $row['regtime'];
  $lasttime = $row['lasttime'];
} else {
  echo outmsg(INVALID_MEMOID);
}
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
    <form> 
    <?=$id?>
    <h1>메모 수정</h1>
    
    <form action="memo_updateprocess.php" method="POST" >
      <input type="hidden" name="id" value="<?=$id?>">
      <label>글쓴이</label><input type="text" name="username" value="<?=$username?>" readonly ><br>
      <label>제목</label><input type="text" name="title" value="<?=$title?>"><br>
      <label>내용</label><input type="text" name="contents" value="<?=$contents?>"><br>
      <label>작성일</label><input type="text" name="regtime" value="<?=$regtime?>" readonly><br>
      <label>수정일</label><input type="text" name="lasttime" value="<?=$lasttime?>" readonly><br>
      <input type="submit" value="수정">
      <!-- <input type="button" value="목록" onclick="location.href='./memo_list.php'"/> -->
    </form>
</body>
</html>

<!-- 
     
    1. readonly 란? 읽기만 가능하게 설정
    2. form내에 input type=submit은 action의 url로 작동 ?
    3. ★★★ detaileview에서 수정으로 넘어갈때 id값 넘겨주고 있는지 확인해야 함. 주소를 ~~.php?id=변수값
-->