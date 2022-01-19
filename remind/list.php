<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>인사정보 리스트</title>
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

    // tbl조회
    $sql="SELECT * FROM employee";
    $resultset=$conn->query($sql); // 실행한 쿼리를 $resultset에 받는다
    ?>

    <h1>인사정보 리스트</h1>
    <table>
        <tr>
           <th>No.</th> 
           <th>이름</th>
           <th>사원번호</th>
           <th>부서코드</th>
        </tr>
    <?php
        while($row=$resultset->fetch_assoc()) {
    ?>
        <tr>
           <td><?=$row['id']?></td> 
           <td><a href="./detailview.php?id=<?=$row['id']?>"><?=$row['emp_name']?></a></td> <!-- get방식 -->
           <td><?=$row['emp_number']?></td>
           <td><?=$row['emp_deptcode']?></td>
        </tr>
    <?php
        }
    ?>
    </table>
    <a href="./insert.php">인사정보 등록</a>

    <?php
        // 리소스 반납
        $resultset->close();
        $conn->close();
    ?>
</body>
</html>


