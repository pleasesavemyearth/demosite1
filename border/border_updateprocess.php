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

  // filename변수에 $_FILES함수로 post로 받아온 파일(image)를 가져오고 ['name']으로 파일명 바꿈
  $filename = $_FILES['uploadfile']['name'];
  // 파일 중복 회피
  $filename = time()."_".$_FILES['uploadfile']['name'];
  // file이 정상적으로 업로드 되었을 때 테이블에 추가
  if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $upload_path.$filename)){
    $sql="SELECT * FROM border WHERE id = ".$id;
    $resultset = $conn->query($sql);
    $row = $resultset->fetch_assoc();
    $existingfile = $row['uploadfile'];
  if(isset($existingfile) && $existingfile != ""){
    // unlink function remove previous file
    unlink($upload_path.$existingfile);
  }

  $stmt = $conn->prepare("UPDATE border SET title = ?, contents = ?, uploadfile = ? WHERE id = ?" );
  //$stmt->bind_param("ssss", $title, $contents, $uploadfile, $id); 오타주의,  $filename = $_FILES['uploadfile']['name']; 을 사용
  $stmt->bind_param("ssss", $title, $contents, $filename, $id);
  $stmt->execute();

  $conn->close();
   
  header('Location: ./border_detailview.php?id='.$id);
  }
  else { // 이미지를 업로드 하지 않고 글 수정 시
    $stmt = $conn->prepare("UPDATE border SET title = ?, contents = ? WHERE id = ?" );
    $stmt->bind_param("sss", $title, $contents, $id);
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
  22-02-16
  1. 이미지 등록 시, 웹상에 이미지는 들어가지만 컴퓨터에(uploadfiles폴더에)는 들어가지 않음 
  -> 파일질러의 리모트사이트 uploadfiles에 들어가있는 것임(즉 서버에 사진을 저장)
  따라서 정상적으로 사진이 들어갔다고 봄
  
  2. 글 수정시 수정을 클릭하면 process로 넘어가나 빈 페이지가 뜨고, db에서 수정도 되지 않음
  -> 사진을 수정시 수정이 잘되고 사진말고 글만 수정시 안되는 경우였는데, updateprocess에서 
  if문을 사진을 수정시에만 수정되게하고 사진이 없을 시 수정하도록 하는 건 설정을 안해놈.
  따라서 else도 추가 작성

------
  문제 :
  이미지 수정 시, border/uploadfiles 폴더에 이미지는 들어가나 
  db에서 있던 이미지 삭제되면서 새로운 이미지는 안들어가지고 -> 웹페이지에는 바뀌지 않고 '이미지가 없습니다'로 뜸

  1. $stmt->bind_param("ssss", $title, $contents, $filename, $id); $filename = $_FILES['uploadfile']['name']; 을 사용해야 함
  2. tbl col을 image라는 keyword 사용


-->