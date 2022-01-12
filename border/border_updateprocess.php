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
  require_once "../util/loginchk.php";

  $upload_path = './uploadfiles/';

  if($chk_login){ 
    $id = $_POST['id'];
    $username = $_POST['username'];
    $title = $_POST['title'];
    $contents = $_POST['contents'];
    $regtime = $_POST['regtime'];

  // filename변수에 
  $filename = $_FILES['image']['name'];
  // 파일 중복 회피
  $filename = time()."_".$_FILES['image']['name'];
  // file이 정상적으로 업로드 되었을 때 테이블에 추가
  if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_path.$filename)){
    $sql="SELECT * FROM border WHERE id = ".$id;
    $resultset = $conn->query($sql);
    $row = $resultset->fetch_assoc();
    $existingfile = $row['image'];
  if(isset($existingfile) && $existingfile != ""){
    // unlink function remove previous file
    unlink($upload_path.$existingfile);
  }
  
  $stmt = $conn->prepare("UPDATE border SET title = ?, contents = ?, image = ? WHERE id = ?" );
  $stmt->bind_param("ssss", $title, $contents, $image, $id);
  $stmt->execute();

  $conn->close();
   
  header('Location: ./border_detailview.php?id='.$id);
  }
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>Confirm and Return to index.</a>";
}
?>
<!-- 
  이미지 수정이 안됨 뭐가 문제 . .?
-->