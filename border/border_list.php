<!-- 
  파일명 : border_list.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 border 데이터를 받아와 게시글 리스트 형태로 나열한다.
-->

<?php
require '../util/dbconfig.php';
require_once '../util/loginchk.php';
if($chk_login) {
    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/style.css">
    <title>게시판 글 목록</title>
</head>
<body>

   <div class="board_area">
    <h1>게시판</h1>

            <?php
                // pagination용 추가====================
                // 1. 페이지를 get으로 받음, 없으면 현재 1페이지
                if(isset($_GET['page_no']) && $_GET['page_no']!="") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }

                // 2. 페이지 당 보여줄 리스트 갯수값 설정
                $total_records_per_page = 10;

                // 3. offset계산, 이전/다음페이지 변수 설정
                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                // 4. 전체 페이지 수 계산
                $sql = "SELECT COUNT(*) AS total_records FROM border";
                $resultset = $conn->query($sql);
                $result = mysqli_fetch_array($resultset);
                $total_records = $result['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1; 
                //========================================

                // $sql = "SELECT * FROM border"; 
                // ★★★아래 sql구문에서 LIMIT 다음에 꼭 공백 있어야 함, LIMIT과 offset이 붙어버리면 숫자가 붙기 때문에 잘못된 질의문★★★
                $sql = "SELECT * FROM border LIMIT ".$offset.",".$total_records_per_page;
                $resultset = $conn -> query($sql);

                if($resultset->num_rows > 0) {
                    echo "<table>
                          <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                            <th>조회수</th>
                            <th>추천수</th>
                          </tr>";
                    while($row = $resultset->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td><a href='./border_detailview.php?id=".$row['id']."'>" .$row['title']."</a></td>
                                <td>".$row['username']."</td>
                                <td>".$row['regtime']."</td>
                                <td>".$row['hit']."</td>
                                <td>".$row['thumbup']."</td>
                              </tr>";
                    }
                    echo "</table>";
                }


                //paginatino을 위해 추가하는 부분================
            ?>

            <ul class="pagination">
                <!-- 현재 페이지가 1보다 클때 -->
                <?php if($page_no > 1){
                    echo "<li><a href='?page_no=1'>처음페이지</a></li>";
                } ?>

                <!-- 현재 페이지가 1보다 작거나 같을때 -->
                <li <?php if($page_no <= 1){
                    echo "class='disabled'";} ?>>
                <!-- 현재 페이지가 1보다 클때 -->
                <a <?php if($page_no > 1){
                    echo "href='?page_no=$previous_page'";} ?>>이전페이지</a>
                </li>

            <?php
                // total_no_of_pages가 묶인 페이지 ?
                // 현재페이지가 counter? 아니면 클릭한 페이지..?
                // counter 가 현재페이지와 같다면 counter활성화
                // 그렇지 않으면 현재페이지는 counter ?
                for($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                    if($counter == $page_no) {
                        echo "<li class='active'><a>$counter</a></li>";
                    } else {
                        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                    }
                }
            ?>
                <!-- 현재페이지가 총페이지보다 크면 -->
                <li <?php if($page_no >= $total_no_of_pages){
                    echo "class='disabled'";} ?>>
                <!-- 현재페이지가 총페이지보다 작으면 -->
                <a <?php if($page_no < $total_no_of_pages){
                    echo "href='?page_no=$next_page'";} ?>>다음페이지</a>
                </li>
                
                <?php if($page_no < $total_no_of_pages){
                    echo "<li><a href='?page_no=$total_no_of_pages'>마지막페이지</a></li>";} 
                ?>
                </ul>

                <?php // 여기까지 pagination을 위해 추가 부분
                //=================================================
            ?>

        <br><br>
        <input type="button" value="글쓰기" onclick="location.href='./border_regist.php'"/> 
        <input type="button" value="홈으로" onclick="location.href='../index.php'"/> 
        <input type="button" value="로그아웃" onclick="location.href='../membership/user_logout.php'"/> 


        
        </div>

</body>
<?php
} else { // 로그인을 하지 않았을 시
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>