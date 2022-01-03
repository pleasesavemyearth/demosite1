<?php
  session_start();
  if(isset($_SESSION['username'])) {
    $chk_login = TRUE;
  }else { 
    $chk_login = FALSE;
  }
?>