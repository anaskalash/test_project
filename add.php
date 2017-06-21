<?php

  /**
  * @author osama haffar & anas kalash
  * @desc add page that adds a new products
  **/
  require_once('product_class.php');
  require_once('Connection.php');
  $Connection = new Connection();
  $db = $Connection->connect(); 
  include("header.php");


  $Product_obj = new Product();//new object from product calss

  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){
      header("location:login.php");die;
   }

 		// username and password sent from form 
  if($_SERVER["REQUEST_METHOD"] == "POST") {


    $msg=$Product_obj->add($db,$_SESSION['user_id']);
    
  }
      
?>

<html>
   <head>
      <title>Add a product</title>
      <link rel="stylesheet" type="text/css" href="button.css">
      <link rel="stylesheet" type="text/css" href="pagenation.css">
   </head>
   <div class="container">
      <div class="row">
         <div class="col-md-5">
            <form action = "" method = "post">
              <div class="form-group"> <br><br>
                        <label> Name  :</label><br /><input type = "text" name = "name" class = "form-control" required/><br /><br />
                        <label> Type  :</label><br />

                          <select name="type" class="form-control">
                            <option value="Desktop">Desktop</option>
                            <option value="Desktop part">Desktop part</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Laptop part">Laptop part</option>
                            <option value="Game Consol">Game Consol</option>
                            <option value="accessories">Accessories</option>
                          </select>
                        <br /><br />
                        <label> Brand  :</label><br /><input type = "text" name = "brand" class = "form-control"  required/><br /><br />
                        <label> Origin  :</label><br /><input type = "text" name = "origin" class = "form-control" required/><br /><br />  
                        <label> More Info  :(optional)</label><br /><textarea id="product_info" name="product_info" class="form-control"></textarea><br /><br />
                        <label> Price :</label><br /><input type = "number" step="0.000001" name="price" class = "form-control" /><br/><br /><br />
                        <input type = "submit" value = " Add Product " name="add" class="button1" />
                        </div>
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