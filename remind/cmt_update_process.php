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

    $cmt_id=$_POST['cmt_id'];
    $emp_id=$_POST['emp_id'];
    $cmt_contents=$_POST['cmt_contents'];

    $stmt=$conn->prepare("UPDATE comment SET cmt_contents = ? WHERE cmt_id = ?");
    $stmt->bind_param("ss", $cmt_contents, $cmt_id);
    $stmt->execute();
  
    $stmt->close();
    $conn->close();
     
    header('Location: ./detailview.php?id='.$emp_id);

?>