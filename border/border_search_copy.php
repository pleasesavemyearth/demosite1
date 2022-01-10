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
    <title>게시판 글 목록</title>
</head>
<body>
    <h6><?=$username?>님이 로그인하셨습니다.</h6>
   <div class="board_area">
    <h1>게시글 검색결과</h1>

            <?php

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

                //=======================================

                // $sql = "SELECT * FROM border"; 
                // ★★★아래 sql구문에서 LIMIT 다음에 꼭 공백 있어야 함, LIMIT과 offset이 붙어버리면 숫자가 붙기 때문에 잘못된 질의문★★★
                // search용 수정
                $sql = "SELECT * FROM border WHERE $category LIKE '%$search%' ORDER BY id DESC LIMIT ";
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