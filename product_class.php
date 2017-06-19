<?php
class product { 


    public function add($db,$user_id) { 
      $name = mysqli_real_escape_string($db,$_POST['name']);
      $type = mysqli_real_escape_string($db,$_POST['type']); 
      $brand = mysqli_real_escape_string($db,$_POST['brand']); 
      $origin = mysqli_real_escape_string($db,$_POST['origin']); 
      $product_info = mysqli_real_escape_string($db,$_POST['product_info']); 
      $price = mysqli_real_escape_string($db,$_POST['price']); 

      $status [] = array("0","0");


      if ($name == null || $price == null) {
         $status[0]=0;
         $status [1] = "You must fill the boxes above";       
         return $status;      
       }
      if (is_float((double)$price)){
          $sql = "insert into products (product_name,user_id,product_price,type,brand,origin,product_info) values ('$name','$user_id','$price','$type','$brand','$origin','$product_info')";

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
  * @author Anas Kalash <>
  * @desc 
  * @param $db
  * @param user_id
  * @param 
  */
  public function edit($db,$user_id,$product_id){

      $name = mysqli_real_escape_string($db,$_POST['name']);
      $type = mysqli_real_escape_string($db,$_POST['type']); 
      $brand = mysqli_real_escape_string($db,$_POST['brand']); 
      $origin = mysqli_real_escape_string($db,$_POST['origin']); 
      $product_info = mysqli_real_escape_string($db,$_POST['product_info']); 
      $price = mysqli_real_escape_string($db,$_POST['price']);  
      
      $status [] = array("0","0");

        if ($name == null || $price == null) {
         $status[0]=0;
         $status [1] = "You must fill the boxes above";       
         return $status;      
        }
        if (is_float((double)$price)){
            $sql = "update products set 
            product_name='$name',product_price='$price',type='$type',brand='$brand',origin='$origin',product_info='$product_info' 
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
                header('Refresh: 1;url=http://localhost:5050/product_list.php');
                return $status;die;
                
            }
        }
        else
        {
          $status = "price must be a number !";
          return $status;
        }  
 

  }

  public function delete($db,$product_id){


      $sqldelete = "DELETE FROM products WHERE id='$product_id'";
      $result = mysqli_query ($db, $sqldelete);


      header ("location:product_list.php");
   }

   public function list($db) { 
        $query[]=['0',"0"];
        $product_per_page=5;

        if(!isset($_GET['id']))
        {
          $start=1; 
        }else{
          $start=$_GET['id']; 
        }
        $offset=($start-1)*$product_per_page;
        $sql="SELECT p.product_name,p.product_price,p.user_id,users.username ,p.id,p.created,p.type,p.origin,p.brand,p.product_info 
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
}

