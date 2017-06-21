<html>

   
  <!--  @author osama haffar 
   @desc global header page 
  -->
   <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="header.css">
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <script type="text/javascript">

  
         
   // @author Anas Kalash 
   // @desc checks form password (strong password)
 
  function checkForm(form)
  {
    if(form.password.value != "" && form.password.value == form.passwordconf.value) {
      if(form.password.value.length < 8 && form.password.value.length > 26) {
        alert("Error: Password must contain at least 8 characters and not more than 25 characters!");
        form.password.focus();
        return false;
      }
      if(form.password.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.password.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.password.focus();
        return false;
      }
  
      re = /[~`!#$@%\^&*+=\-\[\];,/{}|:\?]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one special character !");
        form.password.focus();
        return false;
      }
      re = /[<>\"\']/;
      if(re.test(form.password.value)) {
        alert("Error: Not Allow to use this Char < > \' \" !");
        form.password.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.password.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.password.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password.focus();
      return false;
    }

   
    return true;
  }
</script>
   </head>
   <body>
      <div class="blue-bg-nav">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <header class="header-tp">
                     <nav class="navbar navbar-default navbar-static-top">
                        <div class="navbar-header">
                           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                           <span class="sr-only">Toggle navigation</span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           </button> 
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                           <form class="form-inline">
                              <?php 
                                 if(empty($_SESSION['user_id']) || empty($_SESSION['login_user']))
                                  {
                                   echo  '<a style="color:#FFFFFF;" class="navbar-brand" href="#">Shopify</a>';
                                 
                                  }
                                 ?>
                              <div class="navbar-header">
                                 <?php if(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php" || basename($_SERVER['PHP_SELF']) == "product_list.php") { ?>
                                 <?php if((!isset($_SESSION['login_user'])) || $_SESSION['login_user'] == "Guest") { ?>
                                 <?php  $_SESSION['login_user'] = "Guest"; }?>
                                 <h3><a style="color:#FFFFFF; class="navbar-brand" href="#">
                                    Welcome <?php echo $_SESSION['fname'],' ',$_SESSION['lname'],' | Username : ',$_SESSION['login_user'] ;?></a>
                                 </h3>
                                 <?php } ?>
                              </div>
                              <ul class="nav navbar-nav navbar-right bdr">
                              <?php
                                 if(!(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php" || basename($_SERVER['PHP_SELF']) == "product_list.php")){
                                 ?>
                              <li><a href="#" data-toggle="modal" data-target="#at-login">Sign in</a></li>
                              <li><a href="#" data-toggle="modal" data-target="#at-sign-up">Sign up</a></li>
                              <?php } ?>
                              <ul class="nav navbar-nav pull-left">
                                 <?php
                                    if(basename($_SERVER['PHP_SELF']) == "edit.php" || basename($_SERVER['PHP_SELF']) == "add.php"){
                                    echo '<li><a  href="product_list.php" > Product list </a></li>';
                                    }
                                    
                                    if(!empty($_SESSION['login_user']))
                                    {
                                    echo '<li><a href="/logout.php" > Logout </a></li>';
                                    }
                                    
                                    ?> 
                              </ul>
                           </form>
                        </div>
                        <!--/.nav-collapse -->
               </div>
               </nav>
               </header>
               <section class="at-login-form">
                  <!-- MODAL LOGIN -->
                  <div class="modal fade" id="at-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                           </div>
                           <form action =" " method = "post">
                              <div class="form-group">
                                 <input type="text" name="username" class="form-control-form " id="exampleInputuserlog" placeholder="Username">
                              </div>
                              <div class="form-group">
                                 <input type="password" name="password" class="form-control-form " id="exampleInputPasswordpas" placeholder="Password">
                              </div>
                        </div>
                        <button type="submit" name="login" class="btn-lgin">Login</button>
                        </form>
                     </div>
                  </div>
            </div>
         </div>
         </section>
         <!-- MODAL LOGIN ENDS -->
         <!-- MODAL REGISTER -->
         <section class="at-login-form">
            <div class="modal fade" id="at-sign-up" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     </div>
                     <form action =" " method = "post" onsubmit="return checkForm(this);" >
                        <div class="form-group">
                           <input type="text" name="fname" class="form-control-form " id="exampleInputuserlog" placeholder="First Name" pattern=".{2,}"   required title="2 characters minimum">
                        </div>
                        <div class="form-group">
                           <input type="text" name="lname" class="form-control-form " id="exampleInputuserlog" placeholder="Last Name" pattern=".{2,}"   required title="2 characters minimum">
                        </div>
                        <div class="form-group">
                           <input type="text" name="username" class="form-control-form " id="exampleInputuserlog" placeholder="Username" pattern=".{5,}"   required title="5 characters minimum">
                        </div>
                        <div class="form-group">
                           <input type="text" name="email" class="form-control-form " id="exampleInputEmaillog" placeholder="Email Adress">
                        </div>
                        <div class="form-group">
                           <input type="password" name="password" class="form-control-form " id="exampleInputpasswordpas" placeholder="password">
                        </div>
                        <div class="form-group">
                           <input type="password" name="passwordconf" class="form-control-form " id="exampleInputPasswordpas" placeholder="Confirm Password">
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LfMQCUUAAAAACn6npueXuuYN6ItrJEbd9xds_Di"></div>
                        <br>
                  </div>
                  <button type="submit" name="update" class="btn-lgin">Register</button>
                  </form>
               </div>
            </div>
      </div>
      </div>
      </section>
      <!-- MODAL REGISTER ENDS -->
      </div>
      </div>
      </div>
      </div>
      </div>
   </body>
</html>