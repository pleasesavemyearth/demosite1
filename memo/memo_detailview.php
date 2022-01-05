<!-- 
  파일명 : memo_form.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색한 후 상세 정보를 불러온다.
-->

<?php
require "../util/dbconfig.php";
require_once "../util/loginchk.php";
if($chk_login){
  $username = $_SESSION['username'];
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
    <h6><?=$username?>님이 로그인하셨습니다.</h6>
    <h1>글 보기</h1><br>

    <?php
    // db에서 데이터 가져오기 
    // 메모의 번호 받아와 만족하는 db의 데이터들을 가져온다
     $id = $_GET['id'];

     $sql = "SELECT * FROM memo WHERE id= ".$id; 
     $resultset = $conn -> query($sql);

     if($resultset->num_rows > 0) {
        echo "<table>
              <tr>
                <th>번호</th>
                <th>제목</th>
                <th>내용</th>
                <th>작성자</th>
                <th>작성일</th>
                <th>수정일</th>
              </tr>";
        $row = $resultset->fetch_assoc();
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['title']."</td>
                    <td>".$row['contents']."</td>
                    <td>".$row['username']."</td>
                    <td>".$row['regtime']."</td>
                    <td>".$row['lasttime']."</td>
                  </tr>";
            echo "</table>";
    }
    ?>
    <br>
    <input type="button" value="수정" onclick="location.href='./memo_update.php?id=<?=$row['id']?>'"/>
    <input type="button" value="삭제" onclick="location.href='./memo_deleteprocess.php?id=<?=$row['id']?>'"/>
    <input type="button" value="목록" onclick="location.href='./memo_list.php'"/>

</body>
<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>

<!-- 
    1. Undefined array key "id" 에러 남. 즉, db에 등록된 글을 읽어 불러들이지 못함 
    : detailview 콜하는 곳에서 id값을 안넘기고 있었음, memo_list의 제목을 누르는 a태그에 "<a href='./memo_detailview.php?id= ".$row['id']." '> ".$row['title']." </a>"
    2. ★★★마찬가지로 수정, 삭제 할 때에도 id값 넘겨주고 있는지 확인해야 함. 주소를 ~~.php?id=변수값★★★
    
-->