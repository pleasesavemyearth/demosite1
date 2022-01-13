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


// $sql = "SELECT * FROM reply WHERE id=".$id;
// // 댓글 id 받아오기 실행 질의문

// $sql = "SELECT * FROM border WHERE id=".$id;


$sql = "DELETE FROM reply WHERE id=".$id;
if ($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

$conn->close();

header('Location: ../border/border_detailview.php');

?>

<!--
    해당 col_num의 해당 댓글의 id에 해당하는 댓글을 찾아서 삭제한다
    항상 생각해야 한다
    1. detailview에서 삭제버튼 주소에 id와 col_num 값을 적어야
    이동한 페이지인 deleteprocess에서도 id와 col_num을 받아올 수 있고
    2. col_num도 받아오는 이유 까먹음
-->