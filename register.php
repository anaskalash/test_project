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
  	  // if($_SERVER["REQUEST_METHOD"] == "POST") {

     //  $error = $user -> register($db);
     // }
      if($_SERVER["REQUEST_METHOD"] == "POST") {

         $status= $user->captcha_check();
         if($status==1 ){
            
            $error = $user -> register($db,$ENCKEY);
         }
         else{

            $error="captcha wrong !";
         }
      }
      
     
      
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
            display: inline-block;
            padding-top: 40px;
         }
      </style>

      <script type="text/javascript">

  function checkForm(form)
  {
    if(form.password.value != "" && form.password.value == form.passwordconf.value) {
      if(form.password.value.length < 8 && form.password.value.length > 26) {
        alert("Error: Password must contain at least 8 characters and not more than 25 characters!");
        form.password.focus();
        return false;
      }
      if(form.password.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.password.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.password.focus();
        return false;
      }
  
      re = /[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one special character !");
        form.password.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.password.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.password.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password.focus();
      return false;
    }

   
    return true;
  }
</script>
      
   </head>
   
   <body>
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Register</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post"  onsubmit="return checkForm(this);">
                  <label> First Name  :</label><input type = "text" name = "fname" class = "box" pattern=".{2,}"   required title="2 characters minimum" /><br /><br />      
                  <label> Last Name  :</label><input type = "text" name = "lname" class = "box" pattern=".{2,}"   required title="2 characters minimum" /><br /><br />
                  <label> Create a Username  :</label><input type = "text" name = "username" class = "box" pattern=".{4,}" required title="4 characters minimum" /><br /><br />
                  <label>  Email Adress :<br> </label><input type = "email" name = "email" class = "box" /><br/><br/>
                  <label>  Password  :<br> </label><input type = "password" name = "password" class = "box" required/><br/><br/>
                  <label>  Confirm Password  :<br> </label><input type = "password" name = "passwordconf" class = "box" required/><br/><br/>
                  <?php  $img=rand(0,5);  ?>
                  <img src="img/<?php echo $img;?>.gif" alt="captcha"><br>
                  <label> Enter the text in the image:</label><input type = "text" name = "cap" class = "box" required /><br/><br/> 
                  <input type="hidden" name="cap_index" value="<?php echo $img;?>">
                  <input type = "submit" value = " Register " name="chech_cap" /><br> 

               </form>
                  
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>