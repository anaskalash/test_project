<?php

 /**
  * @author osama haffar & anas kalash
  * @desc index page that views the list and also a login page
  **/

   require_once('Connection.php');
    $Connection = new Connection();
    $db = $Connection->connect(); 
   include("users_class.php");
   include("product_class.php");

   $user = new Users();

   //check if the user is already logged in, can't redirect to login page by using URL , must use logout button
   if(isset($_SESSION['login_user'])){
      header("location:product_list.php");die;
   }
   
 		// username and password sent from form 
  	  if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['login'])){
      $error = $user -> login($db);
      echo "<script> alert('$error') </script>";
        }
      else {
      $error = $user -> register($db);
      echo "<script> alert('$error') </script>";
      }

      }


   include("header.php");
?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="pagenation.css">
       
        <title> Product list </title>
        <style type="text/css">
          #p_table{
            margin-top: 100px;
          }
        </style>
    </head>
    <body>
    

  <div class="container" id="p_table">
   <table class="table table-striped">
      <thead>
         <tr>
            <th>Owner name</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Brand</th>
            <th>Product Origin</th>
            <th>Product Price</th>
            <th>Product Info</th>
            <th> Created date </th>
            <th> Edit </th>
            <th> Delete </th>
         </tr>
      </thead>
      <tbody>
         <?php   $p = new Product(); ?>
         <?php $results=$p->list($db);?>
         <?php  while($row = mysqli_fetch_array($results[0])){ ?>
         <tr>
            <td><?php echo $row['username'];?></td>
            <td><?php echo $row['product_name'];?></td>
            <td><?php echo $row['type'];?></td>
            <td><?php echo $row['brand'];?></td>
            <td><?php echo $row['origin'];?></td>
            <td><?php echo $row['product_price'];?></td>
            <td><?php echo $row['product_info'];?></td>
            <td><?php echo $row['created'];?></td>
            <?php if($_SESSION['user_id'] == $row['user_id'] || $_SESSION['role']== "admin"){?>
            <td><a class="btn btn-success" href="edit.php?id=<?php echo $row['id'] ?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            <td><a class="btn btn-danger" href="delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')" >
               <i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
            <?php }
               else {echo "<td></td><td></td>";} ?>
         </tr>
         <?php }  ?>
      </tbody>
   </table>
   <nav aria-label="Page navigation example">
      <?php $total=$results[1];
         if(!isset($_GET['id'])) {
           $start=1;
         }else{
          $start=$_GET['id'];     
         }
         
         echo "<ul class='pagination'>";
         if($start>1)
         {
           echo "<li class='page-item'><a class='page-link' href='?id=".($start-1)."' class='button'>PREVIOUS</a></li>";
         }
         for($i=1;$i<=$total;$i++){
          if($i==$start) { 
           echo "<li class='active'><a class='page-link' href=#'>".$i."</a></li>"; 
          } else { 
            echo " <li class='page-item'><a class='page-link' href='?id=".$i."'>".$i."</a></li>"; 
          }
         }
         
         if($start!=$total)
         {
           echo "<li class='page-item'><a class='page-link' href='?id=".($start+1)."' class='button'>NEXT</a></li>";
         }
         echo "</ul>";
         
         ?>
   </nav>
</div>
    </body>
</html>