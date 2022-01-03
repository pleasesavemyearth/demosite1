<!-- 
  파일명 : app_initiate.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-3
  업데이트일자 : 2022-1-3
  
  기능: 
  memo 앱의 메모 등록을 위한 memo 테이블을 생성한다.
  이 코드는 납품시 최초 1 회 실행하며, 현재 버전은 백업에 대한 고려는 하지 않았다.

  테이블 구성 : 
  CREATE TABLE `users` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `username` VARCHAR(20) UNIQUE NOT NULL COMMENT 'user account' , `passwd` VARCHAR(256) NOT NULL COMMENT 'user password' , `cellphone` VARCHAR(13) NOT NULL COMMENT 'phone number' , `email` VARCHAR(50) NOT NULL COMMENT 'mail address' , `registdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' , `lastdate` DATETIME NULL COMMENT 'last login date' , `status` INT NULL DEFAULT '0' COMMENT 'activity status' , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'users registration table';
-->

<?php
require "../util/dbconfig.php";

// 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
// 질의 실행과 동시에 실행 결과에 따라 메시지 출력
$sql = "DROP TABLE IF EXISTS memo";
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(DROPTBL_SUCCESS);
}

// 테이블을 생성한다.
// 데이터베이스명과 사용자명에 더 많은 유연성을 부여하며
// 테이블 생성시 데이터베이스 이름을 붙이는 부분을 생략함!!
$sql = " CREATE TABLE `memo`(
  `id` INT(6) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) UNIQUE NOT NULL COMMENT 'username' , 
  `title` VARCHAR(50) NOT NULL COMMENT 'memo title' ,
  `contents` TEXT NOT NULL COMMENT 'memo contents' ,
  `regtime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration time' ,
  `lasttime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last time' ,
  PRIMARY KEY(`id`) 
  )
  ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'memo registration table';";

// 위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
if ($conn->query($sql) == TRUE) {
  if (DBG) echo outmsg(CREATETBL_SUCCESS);
} else {
  echo outmsg(CREATETBL_FAIL);
}

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
// header('Location: index.php');
// 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
// 백그라운드로 처리되도록 할 경우 위 코드로 대체 할 것!!
echo "<a href='../index.php'>Confirm and Return to back</a>";
?>