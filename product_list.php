<?php
include("product_class.php");
require_once('Connection.php');
$Connection = new Connection();
$db = $Connection->connect(); 

// include ("config.php");
include ('header.php');


if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest") { 

       $_SESSION['login_user'] = "Guest";


      if ( isset( $_POST['add'] ) ) { 
        echo "<script type='text/javascript'>alert('You have to register to be able to add products !')</script>";
       }

       
   }

   else {


	if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      
     	   // redirect you to another page " add Page "
    	  if (isset($_POST['add'])) {
  			//Clicked button was add product
  			header("location:add.php");die;
		} 


  

	}	
}

if( $_SESSION['auth_error']==1)
  {
    echo "<script type='text/javascript'>alert('You are Not Auth to do the Action!')</script>";
     $_SESSION['auth_error']=null;
  }
?>
<html>
    <head>
        <style>
             #content
            {
            width: 900px;
            margin: 0 auto;
            font-family:Arial, Helvetica, sans-serif;
            }
            .page
            {
            float: right;
            margin: 0;
            padding: 0;
            }
            .page li
            {
            list-style: none;
            display:inline-block;
            }
            .page li a, .current
            {
            display: block;
            padding: 5px;
            text-decoration: none;
            color: #8A8A8A;
            }
            .current
            {
            font-weight:bold;
            color: #000;
            }
            .button
            {
            padding: 5px 15px;
            text-decoration: none;
            background: #333;
            color: #F3F3F3;
            font-size: 13PX;
            border-radius: 2PX;
            margin: 0 4PX;
            display: block;
            float: left;
            }
            th, td {
              padding: 15px;
              text-align: left;
            } 

            table, th, td {
              border: 1px solid black;
            }

            th {
              height: 50px;
            }

            table {
             width: 100%;
            } 

        </style>
        <title> Product list </title>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Owner name</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Product Brand</th>
                    <th>Product Origin</th>
                    <th>Product Price</th>
                    <th>Product Info</th>
                    <th> Action </th>
                    <th> Created date </th>
                </tr>
            </thead>
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

                <?php if($_SESSION['user_id'] == $row['user_id'] || $_SESSION['role']== "admin"){?>
                <td>
                    <a href="edit.php?id=<?php echo $row['id'] ?>"> Edit  </a>,
                    <a href="delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')" > Delete </a>
                </td>
                <?php }
                    else {echo "<td></td>";} ?>
                <td><?php echo $row['created'];?></td>
            </tr>
            <?php }  ?>
        </table>

        <?php $total=$results[1];
              if(!isset($_GET['id'])) {
                $start=1;
              }else{
               $start=$_GET['id'];     
              }
              if($start>1)
              {
                echo "<a href='?id=".($start-1)."' class='button'>PREVIOUS</a>";
              }
              if($start!=$total)
              {
                echo "<a href='?id=".($start+1)."' class='button'>NEXT</a>";
             }
             echo "<ul class='page'>";
             for($i=1;$i<=$total;$i++){
               if($i==$start) { 
                echo "<li class='current'>".$i."</li>"; 
               } else { 
                 echo "<li><a href='?id=".$i."'>".$i."</a></li>"; 
               }
              }
              echo "</ul>";
        ?>


        <br><br>
        <center>
            <div>
                <form action = "" method = "post">
                <input type = "submit" value = " Add New Product " name="add" /><br> 
            </div>
        </center>
    </body>
</html>