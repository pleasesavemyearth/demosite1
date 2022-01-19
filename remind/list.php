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

    // pagination 변수
    $records_per_page = 10; // 한 페이지에 보여줄 레코드 갯수
    // $page_no = 1; // 페이지번호 - 이거 빠져도 됌 ? 밑에 for문 else에 있어서?

    // 초기에 page_no 없이 list할 때는 page_no 기본값을 1로 하고
    // page_no를 get으로 받아올 수 있으면 받아온 값을 page_no로 대입
    if(isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
    }

    // page1일때, offset0 / page2일때, offset10 / page3일때, offset20 ...
    // page=n일때, offset=(n-1)*records_per_page
    $offset = ($page_no - 1) * $records_per_page;
    
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    // 전체 페이지 수 계산
    $sql="SELECT COUNT(*) AS total_records FROM employee";
    $result=$conn->query($sql);
    $row=$result->fetch_array();
    // $total_records=$row
    // array, assoc 둘 다 한 행씩 가져옴. 차이점은 ?
    // assoc 는 항목 하나하나 이름을
    // array 는 인덱스를

    // tbl조회
    // $sql="SELECT * FROM employee";
    $sql="SELECT * FROM employee LIMIT ".$offset.",".$records_per_page;
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
    <?php
    // 1,2,3...pagination 만들기
    for($count=1;$count<=10;$count++) {
        echo "<a href='list.php?page_no=".$count."'>".$count."</a>&nbsp&nbsp&nbsp";
    }

    ?>
    <br><a href="./insert.php">인사정보등록</a>

    <?php
        // 리소스 반납
        $resultset->close();
        $conn->close();
    ?>
</body>
</html>


