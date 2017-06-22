<?php
/**
  * @author anas kalash & osama haffar
  * @desc logout from session
  **/

   session_start();
   
   if(session_destroy()) {
      header("Location: login.php");
      die;
   }
