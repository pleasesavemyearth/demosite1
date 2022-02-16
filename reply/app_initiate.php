<!-- 
  파일명 : app_initiate.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-13
  업데이트일자 : 2022-1-13
  
  기능: 
  border 앱의 댓글 등록을 위한 reply 테이블을 생성한다.

-->

<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS reply";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

// 테이블을 생성한다. 
$sql = "CREATE TABLE `reply` (
     `id` INT(11) NOT NULL AUTO_INCREMENT , 
     `col_num` INT(11) NOT NULL COMMENT 'col_num' , 
     `username` VARCHAR(50) NOT NULL COMMENT 'reply username' ,
     `contents` TEXT NOT NULL COMMENT 'reply contents' ,
     `regtime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration time' ,
     `lasttime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last time' ,
     PRIMARY KEY(`id`),
     FOREIGN KEY (`col_num`) REFERENCES `border`(`id`) ON DELETE CASCADE
     ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}


// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
echo "<a href='../index.php'>reply 테이블을 생성했습니다. 클릭하면 index 페이지로 이동합니다.</a>";
?>

<!-- 
  col_num : 게시글의 id 
  col_num에 대해 foriegn key 설정해야 함
  FOREIGN KEY (`col_num`) REFERENCES border(`id`) 맞나?
-->