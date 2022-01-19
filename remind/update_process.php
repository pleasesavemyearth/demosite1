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

    // post방식으로 db에 저장된 emp_name값이 넘어와 $emp_name에 저장
    $id=$_POST['id'];
    $emp_phone = $_POST['emp_phone'];
    $emp_deptcode = $_POST['emp_deptcode'];
    $emp_address = $_POST['emp_address'];
    $emp_email = $_POST['emp_email'];


    // id에 해당하는 레코드를 검색하는 질의문 구성
    $stmt=$conn->prepare("UPDATE employee SET emp_phone = ?, emp_deptcode = ?, emp_address = ?, emp_email = ? WHERE id = ?");
    $stmt->bind_param("sisss", $emp_phone, $emp_deptcode, $emp_address,  $emp_email, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header('Location: ./detailview.php?id='.$id);

?>

<!-- 
    stmt bind_param 구성할 때 set다음부터와 where절의 레코드 까지 생각해서 s나 i입력해줘야 한다 

    where절 다음에 오는 id는 string으로 둬도 된다
-->