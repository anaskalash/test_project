<?php 
    include ("config.php");
    ?>
<html>
    <head>
        <style>

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
                padding-top: 10px;

            }

            .a {
                position:fixed;
                right:10px;
                top:5px;
                margin-top: 10px; 
                margin-right: 100px;
                color: white;
            }


        </style>
        <div class="div">
            <form align="right" name="form" method="post" ">
                <label class="logoutLblPos">
                <?php if(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php" 
                      || basename($_SERVER['PHP_SELF']) == "product_list.php") { ?>
                      <a style="position: static;color: white;"  href="/logout.php" > Logout </a>
                 <?php } ?>
                        
                </form>
                </label>

                <?php if(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php") { ?>
                <div><a class="a" href="product_list.php" > << Back </a></div>
                <?php } ?>

                <!-- <?php if(basename($_SERVER['PHP_SELF']) == "product_list.php" ){  ?>
                <div><a class="a" href="add.php" name="add" > Add a new product </a></div>
                <?php } ?> //to make add button a link -->
                
                <?php if(basename($_SERVER['PHP_SELF']) == "register.php") { ?>
                <div><a class="a" href="login.php" > Login Page </a></div>
                <?php } ?> 
                

                <?php if(basename($_SERVER['PHP_SELF']) == "login.php") { ?>
                <div style="position: static margin-top=0px;" class="a" ><a style="color: white;" href="register.php" > Register </a><p></p> 
                <a style="position: static;color: white;"  href="product_list.php" > Login as Guest </a></div>
                <?php } ?>

                <?php if(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php" 
                      || basename($_SERVER['PHP_SELF']) == "product_list.php") { ?>
                <h2>Welcome <?php echo $_SESSION['fname'],' ',$_SESSION['lname'],' | Username : ',$_SESSION['login_user'] ;?></h2>
                <?php } ?>

        </div>
    </head>
</html>