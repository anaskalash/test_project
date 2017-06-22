<?php 
  
  /**
  * @author osama haffar
  **/

  require_once('Connection.php');
	require_once('product_class.php');

  $Connection = new Connection();
  $db = $Connection->connect(); 

  if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest"){ 
      header("location:login.php");die;
   }

	$Product_obj = new Product();

	$product_id=$Product_obj->param_dec($_GET['id']);

  $user_auth_info=$Product_obj->product_auth($db,$_SESSION['user_id'],$product_id);

 if($user_auth_info[0]==1){

      $error=$Product_obj->delete($db,$product_id);
 }else{
  
      header("location:product_list.php");die; 
  
  }
  	












