<?php
require "../util/dbconfig.php";
require_once "../util/loginchk.php";

if($chk_login){

// 변수
$col_num = $_POST['col_num']; // 1번 $_POST
$username = $_SESSION['username'];
$contents = $_POST['contents'];

// db 삽입
$stmt = $conn->prepare("INSERT INTO reply (col_num, username, contents) VALUES (?, ?, ?)");  
$stmt->bind_param("sss", $col_num, $username, $contents);
$stmt->execute();

// 종료
$conn->close();

// 리다이렉션
echo outmsg(COMMIT_CODE);
header('Location: ../border/border_detailview.php?id='.$col_num); // 2번 ?id='.$col_num
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>

<!-- 문제 : 댓글 등록이 안됨 (1번 게시글에 등록했을 때, reply tbl에서 col_num = 1 이 되야 함)
     해결 :
    1. col_num, contents를 post로 넘겨야 함 
    -> 왜냐하면, 댓글 등록 폼에서 post방식으로 넘겼으므로 action에서 넘어온
    registprocess에서도 변수가 post가 되어야 함 (session은 안해도 됨)
    2. 댓글이 등록과정을 거치고 완료되면 이동할 주소에 게시글의 번호를 지정해 줘야 함. 
    -> 왜냐하면 몇번째 게시글에 댓글을 적었는지를 명시해줘야 방금 댓글을 단 게시글로 이동하기 때문
-->