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

    // id 받아오고 tbl조회
    $id=$_GET['id'];
    $sql="SELECT * FROM employee WHERE id= ".$id;
    $resultset=$conn->query($sql);
    // $row = $resultset->fetch_array();
?>
    <h1>인사정보 상세리스트</h1>
    <table>
        <tr>
            <th>No.</th> 
            <th>이름</th>
            <th>사원번호</th>
            <th>전화번호</th>
            <th>입사일</th>
            <th>부서코드</th>
            <th>주소</th>
            <th>이메일</th>
        </tr>
    <?php
        while($row=$resultset->fetch_assoc()) {
    ?>
        <tr>
           <td><?=$row['id']?></td> 
           <td><?=$row['emp_name']?></td> 
           <td><?=$row['emp_number']?></td>
           <td><?=$row['emp_phone']?></td>
           <td><?=$row['emp_hiredate']?></td>
           <td><?=$row['emp_deptcode']?></td>
           <td><?=$row['emp_address']?></td>
           <td><?=$row['emp_email']?></td>
        </tr>
    <?php
        }
    ?>
    </table>
        <a href="./update.php?id=<?=$id?>">수정</a>
        <a href="./delete_process.php?id=<?=$id?>">삭제</a>
        <a href="./list.php">목록</a>
    <?php
        // 리소스 반납
        $resultset->close();
        $conn->close();
    ?>
</body>
</html>

<!-- 수정, 삭제 시 해당하는 글에 대해 동작해야하므로 해당하는 글인 id를 찾아가도록 주소 지정을 id 생각해서 해야 함 -->