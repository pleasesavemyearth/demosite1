<?php
/* 
php와 mysql간의 연결을 설정하고 이를 $conn이라는 변수로 설정
초기화를 위한 연결로써 아직 db는 없는 상태
이 코드를 통해 db, 사용자, 테이블을 생성한다
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
mysqli 생성자 사용
*/
// 첫번째 방법
// $conn = new mysqli("localhost", "root", "");
// 두번째 방법
$hostname = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($hostname, $username, $password);

// mysql 생성자가 반환한 값이 null 이 아니라면 연결 설정 성공
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

// PDO 생성자 사용하여 연결
// try {
//     $conn = new PDO("mysql:host=$hostname;", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
//   } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//   }

// create DB
// 기존의 db 삭제
$dbname = "remind"; // ★★★EXISTS 뒤에 스페이스 줘야 실행이 제대로 된다
$sql ="DROP DATABASE IF EXISTS ".$dbname;
$conn->query($sql);
// 만들고자하는 이름으로 db생성
$sql ="CREATE DATABASE IF NOT EXISTS ".$dbname;
$conn->query($sql);

// create user
// 기존에 존재하는 user가 있으면 삭제
$account = $dbname;
$sql = "DROP USER IF EXISTS ".$account;
$conn->query($sql);
// 만들고자 하는 이름으로 애플리케이션용 계정생성
$sql = "CREATE USER IF NOT EXISTS '" . $account . "'@'%' IDENTIFIED BY '" . $account . "'";
$conn->query($sql);
// 생성된 계정 리소스 제한
$sql = "GRANT USAGE ON *.* TO '" .$account. "'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
$conn->query($sql);
// 생성된 계정에 특정 데이터베이스에 대한 궈한 부여
$sql = "GRANT ALL PRIVILEGES ON `" .$dbname. "`.* TO '" .$account. "'@'%'; "; // 여긴 ` ` 이거여야 함. 앞엔 $dbname, 뒤엔 $account
$conn->query($sql);

//★★★ db 오픈 명시적으로 (mysql에서 use remind; 한거와 같다)
$sql = "use ".$dbname;
$conn->query($sql);

// create tbl
// 존재하는 테이블이 있으면 삭제
$sql = "DROP TABLE IF EXISTS `employee` "; // 선택된 db가 없다
$conn->query($sql);
// 새로운 테이블 생성
$sql = "CREATE TABLE IF NOT EXISTS `" .$dbname. "`.`employee` ( 
        `id` INT(6) NOT NULL AUTO_INCREMENT , 
        `emp_name` VARCHAR(50) NOT NULL , 
        `emp_number` VARCHAR(10) NOT NULL COMMENT '사원번호' , 
        `emp_phone` VARCHAR(13) NULL , 
        `emp_hiredate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '입사일' , 
        `emp_deptcode` INT(6) NULL COMMENT '부서코드' , 
        `emp_address` VARCHAR(200) NULL , 
        `emp_email` VARCHAR(50) NULL , 
        PRIMARY KEY (`id`)
        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci";
$conn->query($sql);

// 모의 데이터 추가
for($i=1;$i<=345;$i++) {
  $emp_name = '관리자'.$i;
  $emp_number = '사원번호test'.$i;
  $stmt=$conn->prepare("INSERT INTO employee(emp_name, emp_number) VALUES (?, ?)");
  $stmt->bind_param("ss", $emp_name, $emp_number);
  $stmt->execute();
}

$stmt->close();
$conn->close();

// 리소스는 항상 반납해야 함
// if($conn != null) { 
//     $conn->close();
//     echo "<script>alert('DBMS와 연결을 종료합니다')</script>";
// }
?>

<!--
    문제 :
    employee tbl이 있다면 삭제 -> 실행이 안되서 주석처리하고 create tbl을 시킴 -> tbl 생성은 됨
    바로 drop tbl 주석 풀고 실행하면 tbl은 삭제되지만 create tbl은 안됨

    해결 :
    db 오픈 명시적으로 지정해줌 ($sql = "use ".$dbname;)

    --
    속성의 이름은 항상 sql에 있는 date의 속성명과 항상 같아야 한다
-->