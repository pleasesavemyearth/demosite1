<!-- 
  파일명 : memo_registprocess.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-4
  업데이트일자 : 2022-1-4
  
  기능: 
  memo_regist.php 의 값을 받아 memo 테이블에 memo 데이터를 추가한다.
-->

<?php
require "../util/dbconfig.php";

// 메모 작성 화면으로 부터 값을 전달 받음
//$username = $_POST['username'];
$title = $_POST['title'];
$contents = $_POST['contents'];

// db에 삽입 
$stmt = $conn->prepare("INSERT INTO memo (title, contents) VALUES (?, ?)");  
$stmt->bind_param("ss", $title, $contents);
$stmt->execute();

// db 연결 리소스 반납
$conn->close();

echo outmsg(COMMIT_CODE);
echo "<a href='./memo_list.php'>메모 목록 페이지로</a>";
// header('Location: memo_list.php');

/* 문제1
1. table의 레코드 이름과 소스파일의 input의 name값 한글자만 틀려도 바로 에러가 나는 것을 알수 있었음
2. 글이 두번째 부턴 db에 등록되지 않음. : username에 유니크줘서 그럼
*/
?>