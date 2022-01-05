<!-- 
  파일명 : memo_list.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-4
  업데이트일자 : 2022-1-5
  
  기능: 
  db에 저장된 memo 데이터를 받아와 table 형태로 나열한다.
-->

<?php
require '../util/dbconfig.php';

// 로그인된 상태일 때만 이 페이지 내용 확인 가능
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
    <title>Document</title>
</head>
<body>
    <h6><?=$username?>님이 로그인하셨습니다.</h6>
    <h1>메모 목록</h1>

            <?php
                $sql = "SELECT * FROM memo";
                $resultset = $conn -> query($sql);

                if($resultset->num_rows > 0) {
                    echo "<table>
                          <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                          </tr>";
                    while($row = $resultset->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td><a href='./memo_detailview.php?id=".$row['id']."'>" .$row['title']."</a></td>
                                <td>".$row['username']."</td>
                                <td>".$row['regtime']."</td>
                              </tr>";
                    }
                    echo "</table>";
                }
            ?>
            
        <br>
        <input type="button" value="글쓰기" onclick="location.href='./memo_regist.php'"/> 
        <input type="button" value="로그아웃" onclick="location.href='../membership/user_logout.php'"/> 

</body>
<?php
} else { // 로그인을 하지 않았을 시
    echo outmsg(LOGIN_NEED);
    echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>

<!-- 
    1. 테이블 레코드와 변수명이 같게 들어갔는지 항상 확인
-->