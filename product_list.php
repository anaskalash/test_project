<?php
/**
  * @author anas kalash & osama haffar
  * @desc view page for products
  **/

include("product_class.php");
require_once('Connection.php');
$Connection = new Connection();
$db = $Connection->connect(); 

$p = new Product();
$product_id = $_GET['id'];


	if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      
     	   // redirect you to another page " add Page "
    	  if (isset($_POST['add'])) {
  			//Clicked button was add product
  			header("location:add.php");die;
		} 

	}	


if( $_SESSION['auth_error']==1)
  {
    echo "<script type='text/javascript'>alert('You are Not Auth to do the Action!')</script>";
     $_SESSION['auth_error']=null;
  }

  
 
  

  include ('header.php');
?>
<html>
   <head>
      <link rel="stylesheet" type="text/css" href="button.css">
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
                     else {echo "<td></td>";} ?>
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
            <a class="btn btn-primary pull-right" href="add.php" >Add New Product <i class="fa fa-plus" aria-hidden="true"></i></a>
         </nav>
      </div>
      <br><br> 
   </body>
</html>