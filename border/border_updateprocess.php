<!-- 
  파일명 : border_updateprocess.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 등록된 border 데이터를 수정하면 수정된 내용을 db에 반영한다.
-->

<?php
  require "../util/dbconfig.php";
  
  $id = $_POST['id'];
  $username = $_POST['username'];
  $title = $_POST['title'];
  $contents = $_POST['contents'];
  $regtime = $_POST['regtime'];
  
  $stmt = $conn->prepare("UPDATE border SET title = ?, contents = ? WHERE id = ?" );
  $stmt->bind_param("sss", $title, $contents, $id);
  $stmt->execute();

  $conn->close();
   
  header('Location: ./border_detailview.php?id='.$id);
  
?>