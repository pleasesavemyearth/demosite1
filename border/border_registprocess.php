<!-- 
  파일명 : border_registprocess.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  border_regist.php 의 값을 받아 border 테이블에 border 데이터를 추가한다.
-->

<?php
require "../util/dbconfig.php";
require_once "../util/loginchk.php";

//border앱 폴더 아래 uploadfiles라는 폴더 생성후 진행함
$upload_path = './uploadfiles/';

if($chk_login){

// 글 작성 화면으로 부터 값을 전달 받음
$username = $_SESSION['username'];
$title = $_POST['title'];
$contents = $_POST['contents'];

// img를 db에 등록을 위해 추가===========================
if(is_uploaded_file($_FILES['image']['tmp_name'])){
  $filename = time()."_".$_FILES['image']['name'];

  if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $upload_path.$filename)){
    if(DBG) echo outmsg(UPLOAD_SUCCESS);
    $stmt = $conn->prepare("INSERT INTO border(username, title, contents, uploadfile) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $title, $contents, $filename);
} else {
  if(DBG) echo outmsg(UPLOAD_ERROR);   
  }
}else {// file을 첨부하지 않은 기존 추가구문이라면 
  $stmt = $conn->prepare("INSERT INTO border(username, title, contents) VALUES(?, ?, ?)");
  $stmt->bind_param("sss", $username, $title, $contents);
} 

// tmpfile변수에 $_FILES함수로 post로 받아온 파일(image)를 가져오고 ['tmp_name']으로 임시파일명으로 바꿈
// $tmpfile = $_FILES['image']['tmp_name'];
// o_name변수에 $_FILES['image']['name']으로 원래 파일명을 넣음
// $o_name = $_FILES['image']['name'];
// 한글파일깨짐을 방지하기 위해 iconv 사용
// iconv([입력 캐릭터셋], [변환하고자하는 캐릭터셋], [문자열]);
// $filename = iconv("UTF-8", "EUC-KR",$_FILES['image']['name']);
// 업로드한 파일이 이동될 수 잇게 폴더 경로를 지정하고 filename변수로 업로드 파일 이름을 가져옴
// $folder = "../upload".$filename;
// tmpfile를 가져와 업로드된 파일이 사용자 지정 디렉토리로 이동
// move_uploaded_file($tmpfile, $folder);


// db에 삽입 
// $stmt = $conn->prepare("INSERT INTO border (username, title, contents, image) VALUES (?, ?, ?, ?)");  
// $stmt->bind_param("ssss", $username, $title, $contents, $image);
// $stmt = $conn->prepare("INSERT INTO border (username, title, contents) VALUES (?, ?, ?)");  
// $stmt->bind_param("sss", $username, $title, $contents);
$stmt->execute();

// db 연결 리소스 반납
$stmt->close();
$conn->close();

echo outmsg(COMMIT_CODE);
//echo "<a href='./border_list.php'>게시판 목록 페이지로</a>";
header('Location: ./border_list.php');
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>

<!-- 
  문제
  1. db에 img 삽입되는 과정 해결하기

  정리
  1. app_initiate.php 에 title이 빠졌었고, 변수 title을 넣어놔버려서 stmt->bind_param 값을 계속 불러올 수 없는 에러가 났었음
-->