<!-- 
  파일명 : memo_deleteprocess.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 memo 데이터를 삭제한다.
-->

<?php 
require '../util/dbconfig.php';

$id = $_GET['id'];

$sql = "DELETE FROM memo WHERE id=" .$id;
if ($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

$conn->close();

header('Location: memo_list.php');

?>

<!-- 
    테이블명 확인
-->