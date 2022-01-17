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

header('Location: ../border/border_detailview.php');

?>
