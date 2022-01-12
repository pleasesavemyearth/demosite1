<!-- 
  파일명 : border_detailview.php
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
    <h1>게시판 글 보기</h1><br>

    <?php
    // 파일 저장 경로
     $upload_path = './uploadfiles/';

     $id = $_GET['id'];

     $sql = "SELECT * FROM border WHERE id= ".$id; 
     $resultset = $conn -> query($sql);

     /* hit update */
     $hit = "UPDATE border SET hit = hit+1 WHERE id=".$id;
     $conn -> query($hit);

     if($resultset->num_rows > 0) {
        echo "<table>";
      ?>
              <tr>
                <th>번호</th>
                <th>제목</th>
                <th>내용</th>
                <th>작성자</th>
                <th>작성일</th>
                <th>수정일</th>
                <th>조회수</th>
                <th>추천수</th>
                <th>첨부파일</th>
              </tr>
              <?php $row=$resultset->fetch_assoc();?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['title']?></td>
                    <td><?=$row['contents']?></td>
                    <td><?=$row['username']?></td>
                    <td><?=$row['regtime']?></td>
                    <td><?=$row['lasttime']?></td>
                    <td><?=$row['hit']?></td>
                    <td><?=$row['thumbup']?></td>
                    <!-- 첨부된 이미지 파일의 이름을 경로명과 함께 출력 -->
                    <td><img src='<?= $upload_path.$row['uploadfile'] ?>' alt='이미지가 없습니다.' width='200px' height='auto'></td>
                </tr>
      </table> 

    <br>
    <input type="button" value="수정" onclick="location.href='./border_update.php?id=<?=$id?>'"/>
    <input type="button" value="삭제" onclick="location.href='./border_deleteprocess.php?id=<?=$row['id']?>'"/>
    <input type="button" value="목록" onclick="location.href='./border_list.php'"/>
  <?php
     }
    ?>
</body>
<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>

<!-- 
  첨부파일2 :
  첨부파일을 추가했다면(이 조건을 어떻게?), 사진이 뜨고
  그렇지 않으면 공백으로 둔다
-->