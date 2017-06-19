<?php 

	
	class Users {

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
         header("location: product_list.php");die;

      }
      }
  }


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
			

   public function log ($db,$action,$product_id ){  
      // $action=array();
      // $action['login']="user log in";
      // $action['logout']="";
      // $action['']="";
      // $action['']="";
      // $action['']="";
      // $action['']="";
      
      $username=$_SESSION['login_user'];
      $user_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

      $sql = "insert into log (username,ip,action) values ('$myusername','$user_ip','$action')";
      $result = mysqli_query($db,$sql);
      if( $result == null )
      {
         return 0;//0 for error

      }
      return 1; // 1 for scsess
   }

   public function captcha_check(){
      $status;
      $captcha=["F62PB","N4EL3","3PLHJ","JHXL3","32BLE","EKWBB"] ;
      $captcha_data=$_POST['cap'];
      $cap_index=$_POST['cap_index'];

      if($captcha_data==$captcha[$cap_index]){ 

         $status =1;// 1 for scsess
                     
         }
      else{
         $status=0;//0 for error
 
      }
      return $status;

   }
   
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
            $_SESSION['active']="1";
            echo "<script type='text/javascript'>alert('your account is activated successfully !')</script>";
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


}





	


	

   

