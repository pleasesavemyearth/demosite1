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

    $cmt_id=$_GET['cmt_id']; // 댓글tbl의 댓글id
    $emp_id=$_GET['emp_id']; // 이걸 추가한다ㅏㅏㅏㅏ

    $sql="DELETE FROM comment WHERE cmt_id=".$cmt_id; 
    $conn->query($sql);

    $conn->close();

    // ★★★ detailview에 $emp_id가 없으므로 댓글을 삭제하고 나서 돌아올 방법이 없다. 그래서 detailvew에 삭제 onclikck 주소를 다시 디테일뷰 페이지로 돌아오게 하기 위해 emp_id=<?id를 쓴다 그리고 여기에 emp id변수 추가
    header('Location: ./detailview.php?id='.$emp_id);

?>