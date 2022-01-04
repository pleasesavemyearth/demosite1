<!-- 
  파일명 : memo_form.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-5
  업데이트일자 : 2022-1-5
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색한 후 상세 정보를 불러온다.
-->

<?php
require "../util/dbconfig.php";
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
    <h1>글 보기</h1><br>

    <?php

    // db에서 데이터 가져오기 
    // 메모의 번호 받아와 만족하는 db의 데이터들을 가져온다
     $id = $_GET['id'];

     $sql = "SELECT * FROM memo WHERE id= " . $id; 
     $resultset = $conn -> query($sql);

     if($resultset->num_rows > 0) {
        echo "<table>
              <tr>
                <th>번호</th>
                <th>제목</th>
                <th>내용</th>
              </tr>";
        $row = $resultset->fetch_assoc();
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['title']."</td>
                    <td>".$row['contents']."</td>
                  </tr>";
            echo "</table>";
    }
    ?>
    <br>
    <input type="button" value="목록" onclick="location.href='./memo_list.php'"/>

</body>
</html>

<!-- 
    1. Undefined array key "id" 에러 남. 즉, db에 등록된 글을 읽어 불러들이지 못함
-->