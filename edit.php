<?php
  require_once('product_class.php');
  require_once('Connection.php');
  $Connection = new Connection();
  $db = $Connection->connect(); 

 // include ("config.php");
  include("header.php");
  
  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){
      header("location:login.php");die;
   }
  
  $Product_obj = new Product(); 
  $product_id = $_GET['id']; 

  $user_auth_info=$Product_obj->product_auth($db,$_SESSION['user_id'],$product_id);
  if($user_auth_info[0]==1)
  {

    $sname = $user_auth_info[1];
    $sprice = $user_auth_info[2];
    $stype = $user_auth_info[3];
    $sbrand = $user_auth_info[4];
    $sorigin = $user_auth_info[5];
    $sinfo = $user_auth_info[6];
    if($_SERVER["REQUEST_METHOD"] == "POST") { //gets name and price sent from form 
      $error=$Product_obj->edit($db,$_SESSION['user_id'],$product_id);
    }
  } 
  else {
   header("location:product_list.php?e=1");die;    
  }


?>

<html>
    <head>
        <title>Edit Product</title>
        <style type = "text/css">
            .logoutLblPos{
            position:fixed;
            right:10px;
            top:5px;
            margin-top: 10px; 
            margin-right: 10px;
            }
            .div {
            background-color:#333333; 
            color:#FFFFFF; 
            }
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
        </style>
    </head>
    <body bgcolor = "#FFFFFF">
        <div align = "center">
            <div style = "width:300px; border: solid 1px #333333; " align = "left">
                <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Edit Your product</b></div>
                <div style = "margin:30px">
                    <form action = "" method = "post">
                        <label> Name  :</label><br /><input type = "text" name = "name" class = "box" value='<?php echo $sname ?>' required/><br /><br />
                        <label> Type  :</label><br />
                          <select name="type" value='<?php echo $stype ?>'>
                            <option value="Desktop">Desktop</option>
                            <option value="Desktop part">Desktop part</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Laptop part">Laptop part</option>
                            <option value="Game Consol">Game Consol</option>
                            <option value="accessories">Accessories</option>
                          </select>
                        <br /><br />
                        <label> Brand  :</label><br /><input type = "text" name = "brand" class = "box" value='<?php echo $sbrand ?>' required/><br /><br />
                        <label> Origin  :</label><br /><input type = "text" name = "origin" class = "box" value='<?php echo $sorigin ?>' required/><br /><br />  
                        <label> More Info  :(optional)</label><br /><textarea id="product_info" name="product_info" ><?php echo $sinfo ?></textarea><br /><br />
                        <label> Price :</label><br /><input type = "number" step="0.000001" name="price" class = "box" value='<?php echo $sprice ?>'/><br/><br /><br />
                        <input type = "submit" value = " Edit Product " name="edit" /><br> 
                    </form>
                   <?php if ($msg[0] == 0 ) { ?>
                    <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $msg[1]; ?></div>
                    <?php } else { ?>
                    <div style = "font-size:11px; color:#008000; margin-top:10px"><?php echo $msg[1]; ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>