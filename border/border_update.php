<!-- 
  파일명 : border_update.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 border데이터를 수정폼으로 불러온다.
-->

<?php
require '../util/dbconfig.php';
require_once '../util/loginchk.php'; // 이거빠지면 자꾸 로그인해도 하라고 뜸

// upload 파일 처리
$upload_path = './uploadfiles/'; 

if($chk_login){
$id = $_GET['id'];
$sql = "SELECT * FROM border WHERE id = ".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_array();
  $username = $row['username'];
  $title = $row['title'];
  $contents = $row['contents'];
  $regtime = $row['regtime'];
  $lasttime = $row['lasttime'];
  //파일 업로드 가져오기
  $uploadfile = $row['uploadfile'];
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
    <form action="./border_updateprocess.php" method="POST" enctype="multipart/form-data">
    <h1>게시판 글 수정</h1>
      <input type="hidden" name="id" value="<?=$id?>">
      <label>글쓴이</label><input type="text" name="username" value="<?=$username?>" readonly ><br>
      <label>제목</label><input type="text" name="title" value="<?=$title?>"><br>
      <label>내용</label><input type="text" name="contents" value="<?=$contents?>"><br>
      <label>작성일</label><input type="text" name="regtime" value="<?=$regtime?>" readonly><br>
      <label>수정일</label><input type="text" name="lasttime" value="<?=$lasttime?>" readonly><br>
      <label>첨부파일</label><input type="file" name="uploadfile" value="<?=$uploadfile?>"/><br>
       <!-- 경로명과 파일명 결합해서 뿌려준다. -->
       <p><img src="<?=$upload_path.$uploadfile?>" width="200px" height="auto" ><br>
      <input type="submit" value="수정">
      <input type="button" value="목록" onclick="location.href='./border_detailview.php?id=<?=$id?>'"/>
    </form>
</body>
<?php
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>

<!-- 
img처리 하기 때문에 아래 form에서 enctype="multipart/form-data" 추가해야 한다
-->