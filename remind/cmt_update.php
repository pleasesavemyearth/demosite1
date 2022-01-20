<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

    $cmt_id=$_GET['cmt_id'];
    $emp_id=$_GET['emp_id'];

    $sql = "SELECT * FROM comment WHERE cmt_id=".$cmt_id; // 하나만 올라올 것
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();

    $cmt_contents=$row['cmt_contents']; 
?>

    <!-- 댓글 수정 -->
    <form action="cmt_update_process.php" method="post">
    <input type="hidden" name="emp_id" value="<?=$emp_id?>">
    <input type="hidden" name="cmt_id" value="<?=$cmt_id?>">
    <textarea name="cmt_contents" cols="100" rows="5" value="<?=$cmt_contents?>"></textarea>

    <input type="submit" value="수정">
</form>

</body>
</html>
<!--
    여기서 33라인 detailview에 class가 cmt_update인 emp_id가 이름인 발류값이랑 왜 다름?
-->

