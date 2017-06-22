<?php

 /**
  * @author osama haffar and anas kalash
  * @desc edit page that views the product selected to edit on it
  **/
 
  require_once('product_class.php');
  require_once('Connection.php');


  $Connection = new Connection();
  $db = $Connection->connect(); 
 



  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){
      header("location:login.php");die;
   }
  
  $Product_obj = new Product(); 
 // $product_id = $_GET['id'];
  $product_id=$Product_obj->param_dec($_GET['id']);


  $user_auth_info=$Product_obj->product_auth($db,$_SESSION['user_id'],$product_id);
  if($user_auth_info[0]==1)
  {
    $sname   = $user_auth_info[1];
    $sprice  = $user_auth_info[2];
    $stype   = $user_auth_info[3];
    $sbrand  = $user_auth_info[4];
    $sorigin = $user_auth_info[5];
    $sinfo   = $user_auth_info[6];

    if($_SERVER["REQUEST_METHOD"] == "POST") { //gets name and price sent from form 
      $msg=$Product_obj->edit($db,$_SESSION['user_id'],$product_id);
    }
  } 
  else {
   header("location:product_list.php");die;    
  }

  include("header.php");
?>

<html>
   <head>
      <link rel="stylesheet" type="text/css" href="button.css">
      <link rel="stylesheet" type="text/css" href="pagenation.css">
      <title>Edit Product</title>
   </head>
   <body>
     <div class="container">
        <div class="row">
           <div class="col-md-5">
              <form action = "" method = "post">
                 <div class="form-group">
                    <br><br>
                    <label> Name  :</label><br /><input type = "text" name = "name" class = "form-control" value='<?php echo $sname ?>' required/><br /><br />
                    <label> Type  :</label><br />
                    <select name="type" class="form-control" value='<?php echo $stype ?>' >
                       <option value="Desktop">Desktop</option>
                       <option value="Desktop part">Desktop part</option>
                       <option value="Laptop">Laptop</option>
                       <option value="Laptop part">Laptop part</option>
                       <option value="Game Consol">Game Consol</option>
                       <option value="accessories">Accessories</option>
                    </select>
                    <br /><br />
                    <label> Brand  :</label><br /><input type = "text" name = "brand" class = "form-control" value='<?php echo $sbrand ?>' required/><br /><br />
                    <label> Origin  :</label><br /><input type = "text" name = "origin" class = "form-control" value='<?php echo $sorigin ?>' required/><br /><br />  
                    <label> More Info  :(optional)</label><br />
                    <textarea id="product_info" class="form-control" name="product_info" ><?php echo $sinfo ?></textarea>
                    <br /><br />
                    <label> Price :</label><br /><input type = "number" step="0.000001" name="price" class = "form-control" value='<?php echo $sprice ?>'/><br/><br /><br />
                    <input type = "submit" value = " Edit Product " name="edit" class="button1" /><br> 
                 </div>
              </form>
           </div>
        </div>
        <?php if ($msg[0] == 0 ) { ?>
        <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $msg[1]; ?></div>
        <?php } else { ?>
        <div style = "font-size:11px; color:#008000; margin-top:10px"><?php echo $msg[1]; ?></div>
        <?php } ?>
     </div>
   </body>
</html>