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

    // id 받아오고 tbl내에 해당하는 id의 레코드 삭제
    $id=$_GET['id'];

    $sql="DELETE FROM employee WHERE id= ".$id;

    $conn->query($sql);

    $conn->close();

    header('Location: ./list.php'); 
    // location: 붙어써야 한다
    // ★★★ 실수: location을 ./detailview로 했을 때 어느 id의 글을 볼건지 설정해줘야 하기 때문에 굳이 하려면
    // <?= => 붙여야 한다 근데 글을 삭제했는데 바로 리스트로 가는게 맞지 ?.

?>