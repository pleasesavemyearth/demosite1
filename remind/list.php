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
    // array, assoc 둘 다 한 행씩 가져옴. 차이점은 ?
    // assoc 는 항목 하나하나 이름을, array 는 인덱스를
    $sql="SELECT COUNT(*) AS total_records FROM employee";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $total_records=$row['total_records'];
    $total_no_of_pages = ceil($total_records/$records_per_page); // 마지막페이지?

    $page_range_size = 10; // 한 페이지에 표시할 페이지블럭 수
    $start_page = floor($page_no/$page_range_size) * $page_range_size + 1; 
    // 처음엔 1, 마지막엔 10이 나와야 하므로 1을 더함
    // floor 란?
    $end_page=$start_page+($page_range_size-1);

    // 스타트가 31이면 엔드는 40, 실제 내용은 35까지 있음
    // 이럴 때를 위해 허상의 페이지블럭들을 안보이게 함
    if($end_page>$total_no_of_pages) {
        $end_page=$total_no_of_pages;
    }
    
    


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
    echo "current page : $page_no / $total_no_of_pages<br>";

    if($page_no>1) {
        echo "<a href='list.php?page_no=1'>처음페이지</a>&nbsp&nbsp&nbsp;";
    }
    if($page_no>1) {
        echo "<a href='list.php?page_no=$previous_page'>이전페이지</a>&nbsp&nbsp&nbsp;";
    } // 2페이지부터 넘어가면 보인다
    
    // 1,2,3...pagination 만들기
    for($count=$start_page;$count<=$end_page;$count++) {
        echo "<a href='list.php?page_no=".$count."'>".$count."</a>&nbsp&nbsp&nbsp;";
    }

    if($page_no<$total_no_of_pages) {
        echo "<a href='list.php?page_no=$next_page'>다음페이지</a>&nbsp&nbsp&nbsp;";
    } 
    if($page_no<$total_no_of_pages) {
        echo "<a href='list.php?page_no=$total_no_of_pages'>마지막페이지</a>&nbsp&nbsp&nbsp;";
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


