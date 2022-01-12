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
require_once '../util/loginchk.php';

if($chk_login){

$id = $_GET['id'];

$upload_path = './uploadfiles/';

$sql = "DELETE FROM border WHERE id=" .$id;
$resultset = $conn->query($sql);
$row = $resultset->fetch_assoc();
$existingfile = $row['uploadfile'];
if(isset($existingfile) && $existingfile != ""){
  unlink($upload_path.$existingfile); // unlink function remove existing file
}

$sql = "DELETE FROM border WHERE id=" . $id;
if ($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  } else {
    echo outmsg(DELETE_FAIL);
  }

$conn->close();

header('Location: ./border_list.php');
}
?>