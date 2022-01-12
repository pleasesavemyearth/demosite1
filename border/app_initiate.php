<!-- 
  파일명 : app_initiate.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  border 앱의 게시글 등록을 위한 border 테이블을 생성한다.
  이 코드는 납품시 최초 1 회 실행하며, 현재 버전은 백업에 대한 고려는 하지 않았다.
-->

<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS border";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

// 테이블을 생성한다. 
$sql = "CREATE TABLE `border` (
     `id` INT(6) NOT NULL AUTO_INCREMENT , 
     `username` VARCHAR(20) NOT NULL COMMENT 'username' ,
     `title` VARCHAR(50) NOT NULL COMMENT 'border title' ,
     `contents` TEXT NOT NULL COMMENT 'border contents' ,
     `regtime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration time' ,
     `lasttime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last time' ,
     `hit` INT(6) NOT NULL COMMENT 'hit' ,
     `thumbup` INT(10) NOT NULL COMMENT 'thumb up' ,
     `uploadfile` VARCHAR(100) NOT NULL COMMENT 'attached file name',
     PRIMARY KEY(`id`) 
     )
     ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'border registration table';";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

if(DBG){
  // 리스트 pagination을 위한 모의 데이터 추가
  $rndnumber = rand(234, 789);  // 레코드의 갯수는 최소 234개에서 789개
  for($count=1;$count<=$rndnumber;$count++) {
    $username = 'admin';
    $title = $count.'번 게시글 제목';
    $contents = $count.'안녕하세요 contents입니다 테스트테스트테스트 123';
    $sql = "INSERT INTO border(username,title,contents) VALUES ('".$username."', '".$title."', '".$contents."')";
    $conn->query($sql);
  }
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
echo "<a href='../index.php'>border 테이블을 생성했습니다. 클릭하면 index 페이지로 이동합니다.</a>";
?>

<!-- 
  image col 생성하면서 , 하나 오타나서,,,,,,에러가;
-->