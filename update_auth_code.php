   public function check_active_code($db){
      $status[]=['0',"0"];
      $email = $_POST['authemail'];
      $code = $_POST['authcode'];

      $sql = "SELECT auth_code 
              FROM users 
              WHERE  email='$email'";
      if(isset($_POST['update'])){
         
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      }
      
      if($count==0){
      
         $status[0]="0";
         $status[1]="no Email Found !";
         return $status;
      }

      if($code==$row['auth_code']){

      $sql = "update users set active=1 where email='$email'";
      $result = mysqli_query($db,$sql);
      $status[0]="1";
      $status[1]="User Avtivated you have full Auth !";
      return $status;
      }
      else{
      $status[0]="0";
      $status[1]="Wrong Code !";
      return $status;

      }


   }
   ---
    $msg=$user->check_active_code($db);
         if($msg[0]=="1")
         {
            header('Refresh: 1;url=http://localhost:5050/login.php');
         }
--


public function register ($db){

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
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
         $code=rand(0,999999);
         $msg="Wellcome to our website Your Activation Code is : '$code'";
         mail($myemail,"Activation Code",$msg);
         $sql = "insert into users 
         (username,passcode,fname,lname,role,email,auth_code) values ('$myusername','$mypassword','$myfname','$mylname','author','$myemail',' $code')";
         $result = mysqli_query($db,$sql);
         header("location:authcode.php");die;
         
      }

      }


   }