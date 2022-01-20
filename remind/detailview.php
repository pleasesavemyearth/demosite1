<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .cmt_list {
        border: 1px solid gainsboro;
        width: 50%;
    }

    .cmt_update {
        display: none;
        /* 
        none : 숨긴 상태
        block : 보여지는 상태     
        */
    }
    .active {
        background-color : red;
      }
    </style>
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

    $login_username = "댓글러";

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

        <hr>
        <h4>댓글</h4>
        
        <!-- 댓글 목록 -->
        <?php
         $sql="SELECT * FROM comment WHERE emp_id=".$id; //댓글tbl의 게시글id = 게시글tbl의 게시글id 인 것을 불러오라
         $resultset=$conn->query($sql);
         while($row=$resultset->fetch_assoc()) {
            //echo $row['cmt_writer'].$row['cmt_contents']."<br>"; 71-78 line 대체가능 
            //★★★row=실행된 sql에 의해 data들이 불러와진것, 그걸을 cmt_id도 적용하기 위해 변수 선언★★★, 혹은 $row['cmt_id']를 location에 대입해도 됨
            $cmt_id=$row['cmt_id']; 
            $cmt_contents=$row['cmt_contents']; 
        ?>
        <div class="cmt_list">
            <p class="cmt_writer"><b><?=$row['cmt_writer']?></b></p>
            <p class="cmt_contents"><?=$row['cmt_contents']?></p>

            <button class="accordion">수정1</button>
            <div class="cmt_update">
                <form action="cmt_update_process.php" method="post">
                    <input type="hidden" name="emp_id" value="<?=$id?>">
                    <input type="hidden" name="cmt_id" value="<?=$cmt_id?>">
                    <textarea name="cmt_contents" cols="100" rows="5" value="<?=$cmt_contents?>"></textarea>
                    <input type="submit" value="등록">
                </form>
            </div>

            <input type="button" value="삭제1" onclick="location.href='./cmt_delete_process.php?cmt_id=<?=$cmt_id?>&emp_id=<?=$id?>'"><br>
        </div>
        <?php    
            }
        ?>

        <!-- 댓글 등록 -->
        <form action="comment_process.php" method="post">
            <input type="hidden" name="emp_id" value="<?=$id?>">
            <input type="hidden" name="cmt_writer" value="<?=$login_username?>">
            <textarea name="cmt_contents" cols="100" rows="5"></textarea>
            <input type="submit" value="등록">
        </form>

    <?php
        // 리소스 반납
        $resultset->close();
        $conn->close();
    ?>

    <script>
    // 변수 선언
    // getElementsByClassName() : 태그의 class="" 속성을 사용하여 접근
    var acc = document.getElementsByClassName("accordion");
    var i;
        
    /*
    acc.length : 변수 acc의 길이를 반환
    addEventListener : 이벤트 등록 함수
    즉, acc[0], acc[1]...마다 click이벤트 실행
    classList.toggel : 클래스값이 있는지 체크함. 있으면 제거하고 없으면 더한다 


    
    수정버튼을 click할때마다 스크립트 내의 function() 함수가 호출됨. target.style.display의 상태에 따라 보였다 안보였다로 만든다.

    nextElementSibling : Element 객체를 반환
    
    block일때 click하면->none으로(숨겨짐)
    none이면 click하면->block으로(보여짐)
    */
    for(i=0; i < acc.length; i++){
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");

        var target = this.nextElementSibling;
        if(target.style.display == "block"){
            target.style.display = "none";
        }else {
            target.style.display = "block";
        }
        });
    }
    </script>
</body>
</html>

<!-- 
    글 수정, 삭제 시 해당하는 글에 대해 동작해야하므로 해당하는 글인 id를 찾아가도록 주소 지정을 id 생각해서 해야 함 
    
    댓글 수정, 삭제 시도 마찬가지로 cmt_id가 댓글의 id이므로 적용
-->