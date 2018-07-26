<?php
require_once 'config.php';
require_once 'class.php';
$user = new User();
?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/logo-nav.css" rel="stylesheet">

  </head>

  <body>



    <!-- Page Content -->
    <div class="container">

<?php
    if(!$user->checkUserCode()){
?>        
        
    <h1 class="mt-5">Registration</h1>
      <form id="form-register">
          <div class="form-group">
              <div class="form-control-plaintext">
                  <label for="login">Login</label>
                      <input type="text" name="login" id="login"  />
                   
              </div>
                <div class="form-control-plaintext">
                  <label for="password">Password</label>
                      <input type="password" name="password" id="password"  />
                      
              </div>
                <div class="form-control-plaintext">
                  <label for="confirm_password">Confirm Password</label>
                      <input type="password" name="confirm_password" id="confirm_password"  />
                     
              </div>
                <div class="form-control-plaintext">
                  <label for="email">Email</label>
                      <input type="text" name="email" id="email"  />
                   
              </div>
               <div class="form-control-plaintext">
                  <label for="name">Name</label>
                      <input type="text" name="name" id="name"  />
                    
              </div>
                <div class="form-control-plaintext">
                    <input type="submit" value="send">
                     <div class="form-validator-reg"> </div>
              </div>
          </div>
      </form> 
        <hr>
        <h2 class="mt-5">Authorization</h2>
          <form id="form-auth">
              <div class="form-group">
                  <div class="form-control-plaintext">
                      <label for="login-auth">Login</label>
                          <input type="text" name="login" id="login-auth"  />
                          <div class="form-validator"> </div>
                  </div>
                    <div class="form-control-plaintext">
                      <label for="password-auth">Password</label>
                          <input type="password" name="password" id="password-auth"  />
                          <div class="form-validator"> </div>
                  </div>

                    <div class="form-control-plaintext">
                        <input type="submit" value="send">
                        <div class="form-validator-auth"> </div>
                  </div>
              </div>  
            </form>  
        </div>
 <?php } else {
    
       echo 'Hello '.$_SESSION['name']. ' <span class="logout">Logout</span>'; 
    
    } ?>         
    </div>

    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/libs/jquery-validate/jquery.validate.min.js" type="text/javascript"></script>
  </body>

</html>

