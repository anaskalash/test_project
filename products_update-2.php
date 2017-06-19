 public function product_auth($db,$user_id,$product_id){

      $auth_info[]=array();
      $sqlname = "select product_name,product_price,user_id,type,brand,origin,product_info 
      from products where id = '$product_id'";
      $result = mysqli_query($db,$sqlname);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $auth_info[1]=$row['product_name'];
      $auth_info[2]=$row['product_price'];
      $auth_info[3]=$row['type'];
      $auth_info[4]=$row['brand'];
      $auth_info[5]=$row['origin'];
      $auth_info[6]=$row['product_info'];
      $fid = $row['user_id']; 
      if($_SESSION['role']== "admin")
      {
        $auth_info[0]=1;
      }
      else
      { 
          if($fid == $user_id){
              $auth_info[0]=1;
          }
          else{
              $_SESSION['auth_error']=1; 
              $auth_info[0]=0;
          }
      }
      return  $auth_info;
  }