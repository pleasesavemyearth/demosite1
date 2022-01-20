<?php
// DB 연결 
$hostname = "localhost";
$username = "remind";
$password = "remind";
$dbname = "remind";
$conn = new mysqli($hostname, $username, $password, $dbname);
if($conn->connect_error) {
    die("connection faild" . $conn->connect_error);
}

$cmt_writer=$_POST['cmt_writer']; // $login_username = "댓글러" 가 아님
$cmt_contents=$_POST['cmt_contents'];
$emp_id=$_POST['emp_id']; // 게시글 id

// db삽입
$stmt = $conn->prepare("INSERT INTO comment (cmt_writer, cmt_contents, emp_id) VALUES (?, ?, ?)");  
$stmt->bind_param("sss", $cmt_writer, $cmt_contents, $emp_id);
$stmt->execute();

$stmt->close();
$conn->close();

header('Location: ./detailview.php?id='.$emp_id); // 무슨 글로 이동할지 주의해서


?>