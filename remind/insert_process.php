<?php
// post방식으로 db에 저장된 emp_name값이 넘어와 $emp_name에 저장
$emp_name = $_POST['emp_name'];
$emp_number = $_POST['emp_number'];
$emp_phone = $_POST['emp_phone'];
$emp_deptcode = $_POST['emp_deptcode'];
$emp_address = $_POST['emp_address'];
$emp_email = $_POST['emp_email'];

// DB 연결
$hostname = "localhost";
$username = "remind";
$password = "remind";
$dbname = "remind";
$conn = new mysqli($hostname, $username, $password, $dbname);
if($conn->connect_error) {
    die("connection faild" . $conn->connect_error);
}

// DB 삽입 (두가지 방법이 있다)
// $sql="INSERT INTO employee (emp_name, emp_number, emp_phone, emp_deptcode, emp_address, emp_email) VALUES '".$emp_name."', '".$emp_number."', '".$emp_phone."', '".$emp_deptcode."', '".$emp_address."', '".$emp_email."'"
// prepared statement 로 구성
$stmt=$conn->prepare("INSERT INTO employee (emp_name, emp_number, emp_phone, emp_deptcode, emp_address, emp_email) VALUES (?, ?, ?, ?, ?, ?)");
// prepare statement와 변수 패러미터를 bind로 묶음
//s는 stirng i는 int, 이곳에 들어가는 건 table의 data type이다
$stmt->bind_param("sssiss", $emp_name, $emp_number, $emp_phone, $emp_deptcode, $emp_address, $emp_email); 
// 질의문 실행
$stmt->execute();

$stmt->close();
$conn->close();

header('Location: ./list.php'); 

?>