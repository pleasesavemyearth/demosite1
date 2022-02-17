<!----------------------------------------------------------------------------- 
  파일명 : dbconfig.php
  최초작성자 : jihyeon
  최초작성일 : 2022-1-3
  업데이트일 : 2022-1-3
  
  기능: 
  DBMS 시스템 접속용 기본 정보 선언.
  실제 애플리케이션 제작에서는 클라이언트 사이트의 환경,
  즉, DBMS의 종류별 configuration 정보를 참조하여 구성함.
------------------------------------------------------------------------------>
<?php
// 프로젝트 시작 전 toyappname을 정한다.
// 두번째 toy부터는 폴더의 이름으로 app의 이름을 정하도록 수정하였다.
// 아래코드는 다음의 의미를 가진다. 
// substr("/currentfolername",1)  /를 제외한 currentfoldername을 얻는다.
//=======================================================
//$toyappname = substr(dirname($_SERVER['PHP_SELF']), 1);
$toyappname = 'demosite1'; //aws시 - demosite1 / fileziler시 - qkrwlgus0317
//========================================================

$dbservername = 'localhost'; // 개발 및 테스트 환경에서는 localhost를 전제로 한다.gg
$dbusername = $toyappname;  // 애플리케이션용 계정을 toy app과 같은 이름으로 생성한다.
$dbpassword = '';  // 애플리케이션용 계정의 패스워드도 같은 이름으로 생성한다. //aws시 - ''; / fileziler시 - a!nvoh03
$dbname = $toyappname;      // 애플리케이션용 데이터베이서의 이름도 같은 이름으로 생성한다.

require_once "../util/utility.php"; // 애플리케이션 지원을 위한 각종 환경 변수 및 function 선언

// 데이터베이스 연결 설정
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// 데이터베이스 연결 확인
// 오류가 있으면 DBCONN_FAIL 메시지 출력 후 프로세스 종료
// 그렇지 않으면 DBCONN_SUCCESS 메시지 출력 후 다음 단계 진행 
// if ($conn->connect_error) {
//   echo outmsg(DBCONN_FAIL);
//   die("연결실패 :".$conn->connect_error);
// } else {
//   if (DBG) echo outmsg(DBCONN_SUCCESS);
// }
?>