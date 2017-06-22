<?php
      
  /**
  * @author osama haffar and anas kalash
  * @desc gives a message for new users to check out thier emails to activate thier accounts
  **/
  
   include("users_class.php");
   include("header.php");
   require_once('Connection.php');
   
   $Connection = new Connection();
   $db = $Connection->connect(); 
   
   $user = new Users();

       // username and password sent from form 
         if(isset($_GET['token'])){ 
            $msg=$user->check_active_token($db);
         }
?>

<html>
   <head>
      <title>Email Verification</title>
      
   </head>
   <body>
      <div class = "container"> <br><br><br>

               <center><b> You need to check your email and verify it, to have full author access on the website! </b><br><br>
               <b>   This page will auto redirect you to login page in 10 seconds ... </b>
            
               <div style = "font-size:30px; color:#cc0000; margin-top:10px"><?php echo $msg[1]; ?></div></center>
               <script type="text/javascript"> setTimeout(function(){location.href="login.php"} , 10000);    </script>
                  
      </div>
   </body>
</html>