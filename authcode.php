<?php
   include("config.php");
   include("users_class.php");
 
   session_start();

   $user = new Users();

  
         //check if the user is already logged in, can't redirect to login page by using URL , must use logout button
    if(isset($_SESSION['login_user'])){
      header("location:product_list.php");die;
   }
 		 // username and password sent from form 
  	
         $msg=$user->check_active_token($db,$ENCKEY);


      
?>

<html>
   
   <head>
      <title>Email Verification</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
            float: center

         }
         
         .box {
            border:#666666 solid 1px;
         }

         form {
            display: all;
            padding-top: 40px;
         }

         .button
            {
            padding: 10px 20px;
            text-decoration: none;
            background: #333;
            color: #F3F3F3;
            font-size: 13PX;
            border-radius: 2PX;
            margin: 10 95PX;
            display: block;
            float: center;
            }

            input {
            	float: center;
            	padding-left: 115px;
            }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
                  <?php if ($msg[0] == 0 ) { ?>
                   <div style = "font-size:50px; color:#cc0000; margin-top:10px"><?php echo $msg[1]; ?></div>
                   <?php } else { ?>
                   <div style = "font-size:50px; color:#008000; margin-top:10px"><?php echo $msg[1]; ?></div>
                  <?php } ?>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>