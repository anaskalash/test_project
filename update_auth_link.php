config:
<?php
	//ini_set('display_errors', '1');

	define('HOST', "localhost");
	define('USERNAME', "root");
	define('PASSWORD', "anas93");
	define('DATABASE', "test");
	$ENCKEY="Classera";
    $db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    session_start();
?>
---
auth code:
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
  	
         $msg=$user->check_active_token($db,$ENCKEY);


      
?>
--
public function register ($db,$ENCKEY){

	    $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
      $mypasswordconf = mysqli_real_escape_string($db,$_POST['passwordconf']); 
      $myfname = mysqli_real_escape_string($db,$_POST['fname']); 
      $mylname = mysqli_real_escape_string($db,$_POST['lname']); 
      $myemail = mysqli_real_escape_string($db,$_POST['email']); 

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

      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count != 0) {
         return $error = "Your Registration Username is already used";
      }
      else {
         if ($mypassword == $mypasswordconf){
         $enc_msg="$myemail+$myusername";
         $token=openssl_encrypt($enc_msg, "AES-128-CBC", $ENCKEY);
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
----

   public function check_active_token($db,$ENCKEY){
      $status[]=['0',"0"];
      $token=$_GET['token'];
      $cipher=base64_decode($token);

      $dec_token=openssl_decrypt($cipher,"AES-128-CBC" , $ENCKEY);

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
            header("location: product_list.php");die;

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
