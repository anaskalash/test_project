<?php
   include("config.php");
   include("users_class.php");
   include("header.php");
   session_start();

   $user = new Users();

   //check if the user is already logged in, can't redirect to login page by using URL , must use logout button
   if(isset($_SESSION['login_user'])){
      header("location:product_list.php");die;
   }
   
 		// username and password sent from form 
  	  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $error = $user -> login($db);


      }

?>

<html>
   
   <head>
      <title>Login</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }

         form {
            display: inline-block;
            padding-top: 40px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">

               <br>
                <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Login " name="Login" /><br>
                  </form>
                  
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>