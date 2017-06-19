---- product list
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


--add

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

--edit - php 

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

-- edit-- view 
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