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

    // detailview의 수정 링크로부터 get방식으로 id값을 얻음
    $id=$_GET['id'];
    // id에 해당하는 레코드를 검색하는 질의문 구성
    $sql="SELECT * FROM employee WHERE id = " .$id;
    // 질의문 실행
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    ?>

    <h1>인사정보 수정화면</h1>
    <form action="update_process.php" method="post">
        <input type="hidden" name="id" value="<?=$row['id']?>"/><br>
        <label>이름</label><input type="text" name="emp_name" value="<?=$row['emp_name']?>" readonly/><br>
        <label>사원번호</label><input type="text" name="emp_number" value="<?=$row['emp_number']?>" readonly/><br>
        <label>전화번호</label><input type="text" name="emp_phone" value="<?=$row['emp_phone']?>"/><br>
        <label>입사일</label><input type="text" name="emp_hiredate" value="<?=$row['emp_hiredate']?>" readonly/><br>
        <label>부서코드</label><input type="text" name="emp_deptcode" value="<?=$row['emp_deptcode']?>"/><br>
        <label>주소</label><input type="text" name="emp_address" value="<?=$row['emp_address']?>"/><br>
        <label>이메일</label><input type="text" name="emp_email" value="<?=$row['emp_email']?>"/><br>
        <input type="submit" value="수정">
        <input type="button" value="취소" onclick="location.href='./detailview.php?id=<?=$id?>'"/>
    </form>

</body>
</html>

<!--
     fomr에 input 태그마다 value를 넣어주는 이유는 입력된 값을 수정하기 위해선 입력되었던 값을 불러오기 위해 value를 통해 불러온다.
     
     input type = hidden 으로 id를 불러오는 이유는 post방식으로 값을 불러오기 때문이다. 수정할 해당하는 글의 id를 불러와야 하므로 hidden으로 숨겨서 불러온다(굳이 보여줄 필요가 x)

     readonly를 설정해서 수정하지 못하고 읽기만 가능하게 만든다
-->