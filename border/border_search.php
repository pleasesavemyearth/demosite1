<!-- 
  파일명 : border_search.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-10
  업데이트일자 : 2022-1-10
  
  기능: 
  border게시글에서 검색에 따른 조건에 맞은 결과를 db에 저장된 border 데이터를 불러와 게시글 리스트 형태로 나열한다.
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
    <title>게시글 검색</title>
</head>
<body>
    <h6><?=$username?>님이 로그인하셨습니다.</h6>
   <div class="board_area">
    <h1>게시글 검색결과</h1>

            <?php
                // pagination용 추가====================
                // 1. 페이지를 get으로 받음, 없으면 현재 1페이지
                if(isset($_GET['page_no']) && $_GET['page_no']!="") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }

                // search용 추가========================
                // 검색변수 (추가)
                $category = $_GET['category']; 
                $search = $_GET['search']; 
                
                // form의 title, contents, username 값을 제목, 내용, 글쓴이로 변경하기 위한 조건문 (추가)
                // if($category == 'title') {
                //     $keyword = '제목';
                // } else if ($category == 'contents') {
                //     $keyword = '내용';
                // } else {
                //     $keyword = '글쓴이';
                // }

                // 2. 검색된 리스트 갯수값
                $total_records_per_page = 10;

                // 3. offset계산, 이전/다음페이지 변수 설정
                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                // 4. 전체 페이지 수 계산
                //$sql = "SELECT COUNT(*) AS total_records FROM border"; 이걸로 하면 검색되어 나타나는 페이지의 갯수가 결과값이 없어도 10개씩 뜨게 됨
                $sql = "SELECT COUNT(*) AS total_records FROM border WHERE $category LIKE '%$search%' ORDER BY id DESC";
                $resultset = $conn->query($sql);
                $result = mysqli_fetch_array($resultset);
                $total_records = $result['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1; 
                //=======================================
                // $sql = "SELECT * FROM border"; 
                // ★★★아래 sql구문에서 LIMIT 다음에 꼭 공백 있어야 함, LIMIT과 offset이 붙어버리면 숫자가 붙기 때문에 잘못된 질의문★★★
                // search용 수정
                $sql = "SELECT * FROM border WHERE $category LIKE '%$search%' ORDER BY id DESC LIMIT ".$offset.",".$total_records_per_page;
                $resultset = $conn -> query($sql);

                if($resultset->num_rows > 0) {
                    echo "<table>
                          <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>글쓴이</th>
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
            <?php
                // 0. 한 pagination에서 몇페이지를 표현할 것인지 반영하여 처리하기
                $page_range_size = 10; // 한라인에 표시할 페이지 수, 예: 10
                $start_page = floor($page_no / $page_range_size)*$page_range_size + 1;
                $end_page = $start_page + ($page_range_size - 1); // 끝 페이지, 예: 20

                // 마지막 페이지는 총페이지보다 크면 같아야 한다
                if($end_page > $total_no_of_pages) {  
                    $end_page = $total_no_of_pages; 
                  }
                  
                // 현재 페이지가 1보다 클때
                // if($page_no > 1){
                //     echo "<li><a href='?page_no=1'>처음페이지</a></li>";
                // }
                // 검색결과시 page뿐만 아니라 category와 search값 가지고 와야 2페이지 이상부터도 보임
                if($page_no > 1){
                    echo "<li><a href='?page_no=1&category=$category&search=$search'>처음페이지</a></li>";
                } 
                ?>

                <!-- 현재 페이지가 1보다 작거나 같을때 -->
                <li <?php if($page_no <= 1){
                    echo "class='disabled'";} ?>>
                <!-- 현재 페이지가 1보다 클때 -->
                <a <?php if($page_no > 1){
                    echo "href='?page_no=$previous_page&category=$category&search=$search'";} ?>>이전페이지</a>
                </li>

            <?php
                // total_no_of_pages가 묶인 페이지 ?
                // 현재페이지가 counter? 아니면 클릭한 페이지..?
                // counter 가 현재페이지와 같다면 counter활성화
                // 그렇지 않으면 현재페이지는 counter ?
                // for($counter = 1; $counter <= $total_no_of_pages; $counter++)
                for($counter = $start_page; $counter <= $end_page; $counter++) {
                    if($counter == $page_no) {
                        echo "<li class='active'><a href='?page_no=$next_page&category=$category&search=$search'>$counter</a></li>";
                    } else {
                        echo "<li><a href='?page_no=$counter&category=$category&search=$search'>$counter</a></li>";
                    }
                }
            ?>

                <!-- 현재페이지가 총페이지보다 크면 -->
                <li <?php if($page_no >= $total_no_of_pages){
                    echo "class='disabled'";} ?>>
                <!-- 현재페이지가 총페이지보다 작으면 -->
                <a <?php if($page_no < $total_no_of_pages){
                    echo "href='?page_no=$next_page&category=$category&search=$search'";} ?>>다음페이지</a>
                </li>
                
                <?php if($page_no < $total_no_of_pages){
                    echo "<li><a href='?page_no=$total_no_of_pages&category=$category&search=$search'>마지막페이지</a></li>";} 
                ?>
                </ul>

                <?php // 여기까지 pagination을 위해 추가 부분
                //===========================================
            ?>
</div>
        <br><br>
        <input type="button" value="글쓰기" onclick="location.href='./border_regist.php'"/> 
        <input type="button" value="홈으로" onclick="location.href='../index.php'"/> 
        <input type="button" value="로그아웃" onclick="location.href='../membership/user_logout.php'"/> 

        <form action = "border_search.php" method = "GET">
            <select name = "category">
                <option value="title">제목</option>
                <option value="contents">내용</option>
                <option value="username">글쓴이</option>
            </select>
            <input type = "text" name = "search" required />
            <button>검색</button>
        </form>

</body>
<?php
} else { // 로그인을 하지 않았을 시
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>