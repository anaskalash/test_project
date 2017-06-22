<?php
class product { 
  const ENCKEY   = "Classera_url_key";

  /**
  * @author Anas Kalash 
  * @desc add a new product to the list
  * @param $db : Database link
  * @param  $user_id user id taken from session
  * @return gives a status message with success or failure
  **/
  public function add($db,$user_id) { 
    $name         = mysqli_real_escape_string($db,$_POST['name']);
    $price        = mysqli_real_escape_string($db,$_POST['price']); 
    $type         = mysqli_real_escape_string($db,$_POST['type']); 
    $brand        = mysqli_real_escape_string($db,$_POST['brand']); 
    $origin       = mysqli_real_escape_string($db,$_POST['origin']); 
    $product_info = mysqli_real_escape_string($db,$_POST['product_info']); 

    $status [] = array("0","0");


    if ($name == null || $price == null || $type == null || $brand == null || $origin == null ) {
      $status[0]=0;
      $status [1] = "You must fill the boxes above";       
      return $status;      
    }
    if (is_float((double)$price)){
        $sql = "insert into products (product_name,user_id,product_price,type,brand,origin,product_info)
                values ('$name','$user_id','$price','$type','$brand','$origin','$product_info')";

        $result = mysqli_query($db,$sql);
        if ($result == null){
          $status[0]=0;
          $status [1] = "You must fill the boxes above";
          return $status;
        }
        $status[0]=1;
        $status[1]= "Product has been added successfully !";
        header('Refresh: 1;url=http://localhost:5050/product_list.php');
        return $status;
    }
    else
    {
        $status[0]=0;
        $status[1]= "price must be a number !";
        return $status;

    }
  }

  /**
  * @author anas kalash 
  * @desc check for product information and authrization info 
  * @param $db : Database link
  * @param  $user_id user id taken from session
  * @param  $product_id product id number taken from database using joining
  * @return gives a status message with success or failure
  **/
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

  /**
  * @author anas kalash & osama haffar
  * @desc Edits a product information
  * @param $db : Database link
  * @param  $user_id user id taken from session
  * @param  $product_id product id number taken from database using joining
  * @return gives a status message with success or failure
  **/
  public function edit($db,$user_id,$product_id){

      $name         = mysqli_real_escape_string($db,$_POST['name']);
      $price        = mysqli_real_escape_string($db,$_POST['price']); 
      $type         = mysqli_real_escape_string($db,$_POST['type']); 
      $brand        = mysqli_real_escape_string($db,$_POST['brand']); 
      $origin       = mysqli_real_escape_string($db,$_POST['origin']); 
      $product_info = mysqli_real_escape_string($db,$_POST['product_info']); 

      $status [] = array("0","0");

       if ($name == null || $price == null || $type == null || $brand == null || $origin == null ) {
         $status[0]=0;
         $status [1] = "You must fill the boxes above";       
         return $status;      
      }
      if (is_float((double)$price)){

        if($_SESSION['role']=="admin"){
          $presql = "select product_name , product_price,origin,type,brand,product_info from products where id = $product_id";
          $preresult = mysqli_query($db,$presql);
          $prerow = mysqli_fetch_array($preresult); }

          $sql = "update products set product_name='$name',product_price='$price',product_info='$product_info'
                 ,origin='$origin',type='$type',brand='$brand'
                  where id='$product_id'";
          $result = mysqli_query($db,$sql);
          if ($result == null){
              $status[0]=0;
              $status[1]="Input Error";
              return $status;
          }
          else {
              $status[0]=1;
              $status[1]="Edited successfully !";
              if($_SESSION['role']=="admin"){
                  $sql=" select users.email, products.product_name ,products.product_price
                         from users 
                         inner join products on products.user_id = users.id
                         where products.id = $product_id";
                 $query=mysqli_query($db,$sql);
                 $row = mysqli_fetch_array($query);
                 $msg = "Super Admin just Edited Your Product
                         Product Name ( $prerow[0] ) | New Product name ( $row[1] )    
                         Product Price ( $prerow[1] ) | New Product Price ( $row[2] )  ";
                  mail($row['email'],"Admin Action Alert",$msg);
              }
              header('Refresh: 1;url=http://localhost:5050/product_list.php');
              return $status;
          }
      }
      else
      {
        $status = "price must be a number !";
        return $status;
      }  


  }

  /**
  * @author anas kalash 
  * @desc deletes a product from database
  * @param $db : Database link
  * @param  $user_id user id taken from session
  **/
  public function delete($db,$product_id){

    if($_SESSION['role']=="admin"){
      $sql=" select users.email, products.product_name ,products.product_price
             from users 
             inner join products on products.user_id = users.id
             where products.id = $product_id";

      $query=mysqli_query($db,$sql);
      $row = mysqli_fetch_array($query);
      $msg = "Super Admin just Deleted Your Product
              Product Name ( $row[1] ) | Product Price ( $row[2] )  ";
      mail($row['email'],"Admin Action Alert",$msg);
    }

    $sqldelete = "DELETE FROM products WHERE id='$product_id'";
    $result = mysqli_query ($db, $sqldelete);


    header ("location:product_list.php");
   }


  /**
  * @author osama haffar
  * @desc show items on product list
  * @param $db : Database link
  * @return returns array contains a status of success or failure and information about products
  **/
   public function list($db) { 
        $query[]=["0","0"];
        $product_per_page=5;

        if(!isset($_GET['id'])){
          $start=1; 
        }else{
          $start=$_GET['id']; 
        }
        $offset=($start-1)*$product_per_page;
        $sql="SELECT p.product_name,p.product_price,p.type,p.brand,p.origin,p.product_info,p.user_id,users.username ,p.id,p.created 
              FROM products as p 
              inner join users on p.user_id = users.id 
              order by created desc
              LIMIT $offset, $product_per_page";
        $query[0]=mysqli_query($db,$sql);

        $rows=mysqli_num_rows(mysqli_query($db,"select id from products"));
              $limit=$product_per_page; 
              $query[1]=ceil($rows/$limit);
        return($query);

        
   }

  /**
  * @author Anas Kalash 
  * @desc Encrypt the given parameter
  * @param $parm:the parameter we need to encrypt it
  * @return the encryped parameter
  **/
  public function param_enc($param){
    $param_enc_phase1=openssl_encrypt($param, "AES-128-CBC", self::ENCKEY);
    $param_encrypted=base64_encode($param_enc_phase1);
    return $param_encrypted;
  }


  /**
  * @author Anas Kalash 
  * @desc decrypt the given parameter
  * @param $parm:the parameter we need to decrypt it
  * @return the decrypted parameter
  **/
  public function param_dec($param){
    $param_dec_phase1=base64_decode($param);
    $param_decrypted =openssl_decrypt($param_dec_phase1, "AES-128-CBC", self::ENCKEY);
    return $param_decrypted;
  }
}