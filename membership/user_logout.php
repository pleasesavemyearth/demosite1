<!-- 
  파일명 : user_logout.php
  최초작업자 : jihyeon
  최초작성일자 : 2022-1-3
  업데이트일자 : 2022-1-3
  
  기능: 
  로그인된 사용자가 로그아웃 한다. 
-->

<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["userip"]);
    setcookie("username", "");
    setcookie("passwd", "");
    header("Location: ../index.php");
?>