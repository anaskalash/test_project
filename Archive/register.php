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
  	  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $error = $user -> register($db,$ENCKEY);
     }     
   include("header.php");
?>

<html>
   <head>
      <title>Register</title>
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
         display: all;
         padding-top: 40px;
         }
         .button:hover{
          background: #066042;
          color: #FFFFFF;
          border-color: #FFFFFF;

         }
         .button
         {
         padding: 5px 15px;
         text-decoration: none;
         background: #FFFFFF;
         border-color: #066042;
         color: #333333;
         font-size: 13PX;
         border-radius: 20PX;
         margin: 0 4PX;
         display: all;
         float: center;
         }
      </style>
      <script src='https://www.google.com/recaptcha/api.js'></script>
   </head>
   <body bgcolor = "#FFFFFF">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <form action="" method="post">
                  <div class="form-group">
                     <label>  First Name  :</label><input type = "text" name = "fname" class = "form-control"/><br /><br />
                     <label>  Last Name  :</label><input type = "text" name = "lname" class = "form-control" /><br/><br />
                     <label>  Username  :<br> </label><input type = "text" name = "username" class = "form-control"/><br /><br/>
                     <label>  Email Adress :<br> </label><input type = "email" name = "email" class = "form-control"/><br/><br/>
                     <label>  Password  :<br> </label><input type = "password" name = "password" class = "form-control" /><br/><br/>
                     <label>  Confirm Password  :<br> </label><input type = "password" name = "passwordconf" class = "form-control" /><br/><br/>
                     <div class="g-recaptcha" data-sitekey="6LfMQCUUAAAAACn6npueXuuYN6ItrJEbd9xds_Di"></div>
                     <br>
                     <input type = "submit" value = " Register " name="update" class="button" />
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
      </div>
      </div>
      </div>
   </body>
</html>