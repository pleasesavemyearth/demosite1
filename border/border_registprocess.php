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

if($chk_login){

// 메모 작성 화면으로 부터 값을 전달 받음
$username = $_SESSION['username'];
$title = $_POST['title'];
$contents = $_POST['contents'];

// db에 삽입 
$stmt = $conn->prepare("INSERT INTO border (username, title, contents) VALUES (?, ?, ?)");  
$stmt->bind_param("sss", $username, $title, $contents);
$stmt->execute();

// db 연결 리소스 반납
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
  1. app_initiate.php 에 title이 빠졌었고, 변수 title을 넣어놔버려서 stmt->bind_param 값을 계속 불러올 수 없는 에러가 났었음
-->