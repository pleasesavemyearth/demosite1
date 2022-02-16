<!-- 
  파일명 : border_deleteprocess.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 border 데이터를 삭제한다.
-->

<?php 
require '../util/dbconfig.php';

$id = $_GET['id']; // 댓글 id
$col_num = $_GET['col_num']; // 게시글 id


// 삭제
$sql = "DELETE FROM reply WHERE id=".$id;
if ($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

$conn->query($sql);

$conn->close();

header('Location: ../border/border_detailview.php?id='.$col_num);
// header('Location: ../border/border_list.php');


?>
<!--
  21-02-16
  댓글 삭제시 db에서 삭제는되지만 돌아오는 detailview에선 에러가 남
  -> detailview로 돌아오는 것까지 됨 : 디테일뷰 페이지에 while밑에 $col_num=$row['col_num']; 추가
  (저거 없으면 col_num값을 못 받아오기 때문)

  댓글 삭제가 1번글만 되고 2번글은 안됨, 2번글에서 댓글을 지우고나서 1번글 댓글을 지우려면 안지워짐
  -> 삭제 버튼을 검사했을 때, 2번댓글&1번글 인데도 id=1&col_num=1
  즉, 모든 id가 1로 고정되어서 떴는데 이는 detailview에서 id값을 변수에 받아오지 않았기 때문이다
  따라서 댓글목록을 while로 뿌려주는 곳 바로 밑에 rep_id변수에다 reply테이블의 id값을 저장시켜 준다음
  삭제버튼 클릭시 php?id=는 rep_id로 이동하게 하면, 각 댓글에 맞는 id가 지정됨.

-->