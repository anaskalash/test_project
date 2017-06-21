<?php 
  
    /**
  * @author osama haffar
  **/
  require_once('Connection.php');
  $Connection = new Connection();
  $db = $Connection->connect(); 
	require_once('product_class.php');

  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){ 
      header("location:login.php");die;
   }

	$Product_obj = new Product();

	$product_id = $_GET['id'];

    $user_auth_info=$Product_obj->product_auth($db,$_SESSION['user_id'],$product_id);

     if($user_auth_info[0]==1){

       $error=$Product_obj->delete($db,$product_id);
    }
    else{
      header("location:product_list.php");die; 
    }
  	












