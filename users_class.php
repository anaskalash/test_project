<?php
	
	class Users {
    const ENCKEY   = "Classera_user_key";

      /**
  * @author osama haffar 
  * @desc checks username and password from DB to gain access 
  * @param $db : Database link
  * @return gives a status message with success or failure
  **/
		public function login ($db){

			   $myusername = mysqli_real_escape_string($db,$_POST['username']);
      	 $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
	 		 if ($myusername == null || $mypassword == null){
        	  $error = "You must fill the boxes above";
        	  return $error;
         }
			else{
      $sql = "SELECT * FROM users WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count != 1 ) {
        $error = "Username or Password is invalid";
        return $error;
      }

      else if ($row['active'] != 1){
        $error = "You need to verify your email adress to have author access on the website !";
        return $error;
      }
      
      else {
         $_SESSION['login_user'] = $row['username'];
         $_SESSION['user_id'] = $row['id'];
         $_SESSION['role'] = $row['role'];
         $_SESSION['fname'] = $row['fname'];
         $_SESSION['lname'] = $row['lname'];
         header("location: product_list.php");
      }
   		}
	}


  /**
  * @author osama haffar 
  * @desc register a new user to the database 
  * @param $db : Database link
  * @return gives a status message with success or failure
  **/
	public function register ($db){

	    $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $mypasswordconf = mysqli_real_escape_string($db,$_POST['passwordconf']);
      $myfname = mysqli_real_escape_string($db,$_POST['fname']); 
      $mylname = mysqli_real_escape_string($db,$_POST['lname']); 
      $myemail = mysqli_real_escape_string($db,$_POST['email']); 
      $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfMQCUUAAAAAKIRSQ0yfJlg8A5x5nTneNGETvr-&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);

      // checks if the boxes are empty or not 
      if ($myusername == null || $mypassword == null){
          return $error = "You must fill the boxes above";
      }
      else {
      $sql = "SELECT username,email 
              FROM users 
              WHERE username='$myusername' OR email='$myemail'";

      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      

      // If result matched $myusername and $myemail, table row must be 1 row
      if($count != 0) {
         return $error = "Your Registration Username or Email is already used !";
      }
       else {
         if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          return $error = "Please Check reCaptcha Checkbox !";
        }
        
        if($response.success==false){
          return $error = "Please Check reCaptcha Checkbox !";
        }
        else {
          if ($mypassword == $mypasswordconf){
               $enc_msg="$myemail+$myusername";
               $token=openssl_encrypt($enc_msg, "AES-128-CBC", self::ENCKEY);
               $enc_token=base64_encode($token);
               $activation_link="http://localhost:5050/authcode.php?token=$enc_token";
               $msg="Wellcome to our website Your Activation Code is : $activation_link";
               mail($myemail,"Activation Code",$msg);
               $sql = "insert into users 
               (username,passcode,fname,lname,role,email) values ('$myusername','$mypassword','$myfname','$mylname','author','$myemail')";
               $result = mysqli_query($db,$sql);
               header("location:authcode.php");die;
          }
          else{
           return $error = "The passwords you entered are not identical ";
        }
         
        }
        

     
         
       }

      }
	}

  /**
  * @author Anas Kalash 
  * @desc checks token to activate user account
  * @param $db : Database link
  * @return gives a status message with success or failure
  **/
  public function check_active_token($db){
      $status[]=['0',"0"];
      $token=$_GET['token'];
      $cipher=base64_decode($token);
      $dec_token=openssl_decrypt($cipher,"AES-128-CBC" , self::ENCKEY);


      if($dec_token!=null){
          $msg= explode("+", $dec_token);

          $sql = "SELECT username,role,id,fname,lname 
                  FROM users 
                  WHERE  email='$msg[0]' AND username='$msg[1]'";

          $result = mysqli_query($db,$sql);
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $count = mysqli_num_rows($result);
          if ( $count ==1 ){
            $sql = "update users set active=1 where email='$msg[0]'";
            $result = mysqli_query($db,$sql);
            $status[0]="1";
            $_SESSION['login_user'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            echo "<script type='text/javascript'> setTimeout(function(){location.href='login.php'} , 10000);    </script>";
          }
          else{
            $status[0]="0";
            $status[1]="Error in Token !";
            return $status;
          }
      
     }else{
        $status[0]="0";
        $status[1]="Error in Token !";
        return $status;
     }
   }

}


	


	

   

