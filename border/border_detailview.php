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
    <title>게시판 글 상세보기</title>
</head>
<body>
    <h6><?=$username?>님이 로그인하셨습니다.</h6>
    <h1>게시판 글 보기</h1><br>
    <?php
     $id = $_GET['id'];
     $col_num = $_GET['col_num']; // warning 생김 
     $upload_path = './uploadfiles/'; // 파일 저장 경로

     $sql = "SELECT * FROM border WHERE id= ".$id; 
     $resultset=$conn->query($sql);

     // hit update 
     $hit = "UPDATE border SET hit = hit+1 WHERE id=".$id;
     $conn->query($hit);
     
     if($resultset->num_rows > 0) {
      echo "<table>";
    ?>
    <!-- 글 상세보기 -->
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
        <td><img src='<?= $upload_path.$row['uploadfile'] ?>' alt='이미지가 없습니다.' width='200px' height='auto'></td>
      </tr>
    </table> 
      <input type="button" value="수정" onclick="location.href='./border_update.php?id=<?=$id?>'"/>
      <input type="button" value="삭제" onclick="location.href='./border_deleteprocess.php?id=<?=$id?>'"/>
      <input type="button" value="목록" onclick="location.href='./border_list.php'"/>
    <?php
      } // 글 상세보기 if문 닫음
    ?>
    
      <!-- 댓글 목록 -->
        <br><p1>댓글 목록</p1>
        <?php
           $sql = "SELECT * FROM reply WHERE col_num= ".$id; 
           $resultset = $conn -> query($sql);

           while($row=$resultset->fetch_assoc()) { // 1번 while문
            $rep_id=$row['id']; 
            $col_num=$row['col_num']; 
            echo "<table>";
        ?>
          <tr>
            <th>작성자</th>
            <th>내용</th>
            <th>작성일</th>
          </tr>
          <tr>
            <td><?=$row['username']?></td>
            <td><?=$row['contents']?></td>
            <td><?=$row['regtime']?></td>
          </tr>
        </table>
          <input type="button" value="수정" onclick="location.href='../reply/reply_updateprocess.php?id=<?=$rep_id?>'"/>
          <input type="button" value="삭제" onclick="location.href='../reply/reply_deleteprocess.php?id=<?=$rep_id?>&col_num=<?=$col_num?>'"/>
        <?php
          } // 댓글 목록 while문 닫음 
        ?>

      <!-- 댓글 수정 -->
        <form action="../reply/reply_updateprocess.php" method="post"> 
          <input type ="text" hidden name="col_num" value="<?=$id?>">
          <textarea name="contents" cols="100" rows="5"></textarea>
          <input type="submit" value="수정" />
        </form>

      <!-- 댓글 등록 -->
        <p3>댓글 쓰기</p3>
        <form action="../reply/reply_registprocess.php" method="post"> <!-- 2번 post방식 -->
          <input type ="text" hidden name="col_num" value="<?=$id?>">
          <textarea name="contents" cols="100" rows="5"></textarea>
          <input type="submit" value="등록" />
        </form>
<!-- 글 정보 if 닫는 괄호 있던 자리-->
</body>
<?php
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>

<!-- 
    문제 1 : 댓글 등록이 안됨 (1번 게시글에 등록했을 때, reply tbl에서 col_num = 1 이 되야 함)
    해결 :
    1. 댓글 등록하는 부분이 while문이 되어야 함 
    -> 왜냐하면, 게시글은 한 번만 올리기 때문에 반복이 한번만 돌면 되어서 if문을 사용하는데
    댓글은 한 게시글에 여러 id가 달릴 수 있기 때문에 while을 사용해야 한다
    그래서 while($row=$resultset->fetch_assoc()) 로 수정함
    2. post방식으로 값을 넘겨주는데 input type 을 통해 id를 hidden으로 넘겨줘야 함
    -> 왜냐하면, 그 이유는 까먹음
    
    !!!get으로 하려면 <a href='?page_no=$counter&category=$category&search=$search'>$counter</a> 
    이런식으로 category와 search 넘기는 값 명시되있어야 함
    그런데 왜 삭제 버튼이 눌러도 활성을 안해 ? 이 이유는 문제 2 로

    ★★★ 문제 2 :
    댓글 삭제 시, col_num이 안잡힌다 ->  $col_num = $_GET['col_num']; 추가하면 첫번째? 한개의 댓만 삭제되고
    넘어가는 페이지에서 에러, deleteprocess update문 수정필요


    해결해야 함 :
    1. <p3>댓글 쓰기</p3> 왜 ?
    2. 첨부파일을 추가했다면(이 조건을 어떻게?), 사진이 뜨고
       그렇지 않으면 공백으로 둔다
    3. 수정 클릭 시, 수정 폼이 뜨도록 js로 처리해야 함
-->