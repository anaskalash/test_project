<?php
  require_once('product_class.php');
  include ("config.php");
  include("header.php");
//print_r($_POST);
//die;
  $Product_obj = new Product();//new object from product calss

  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){
      header("location:login.php");die;
   }

 		// username and password sent from form 
  if($_SERVER["REQUEST_METHOD"] == "POST") {


    $error=$Product_obj->add($db,$_SESSION['user_id']);
    
  }
      
?>

<html>
    <head>

        <title>Add a product</title>
    </head>

    <body bgcolor = "#FFFFFF">
        <div align = "center">
            <div style = "width:300px; border: solid 1px #333333; " align = "left">
                <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Add a new product</b></div>
                <div style = "margin:30px">
                    <form action = "" method = "post">
                        <label> Name  :</label><br /><input type = "text" name = "name" class = "box" required/><br /><br />
                        <label> Type  :</label><br />

                          <select name="type">
                            <option value="Desktop">Desktop</option>
                            <option value="Desktop part">Desktop part</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Laptop part">Laptop part</option>
                            <option value="Game Consol">Game Consol</option>
                            <option value="accessories">Accessories</option>
                          </select>
                        <br /><br />
                        <label> Brand  :</label><br /><input type = "text" name = "brand" class = "box"  required/><br /><br />
                        <label> Origin  :</label><br /><input type = "text" name = "origin" class = "box" required/><br /><br />  
                        <label> More Info  :(optional)</label><br /><textarea id="product_info" name="product_info"></textarea><br /><br />
                        <label> Price :</label><br /><input type = "number" step="0.000001" name="price" class = "box" /><br/><br /><br />
                        <input type = "submit" value = " Add Product " name="add" />
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