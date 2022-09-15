<!-- login is useless, there is no session. -->
<!DOCTYPE html>
<html>
   <head><title>login</title></head>
   <?php include 'Templates/header.php'; ?>
   <?php include 'config/db_connect.php';?>
   
   <?php
      $username = $password =  $status = '' ;
      $errors = array('username' => '', 'password' => '');

      if(isset($_POST['login'])){
         $username = mysqli_real_escape_string($connect, $_POST['username']);
         $sql = "SELECT id FROM user WHERE (username = '$username')";
         $result = mysqli_query($connect, $sql);
         //check if username exist 
         if(mysqli_num_rows($result) > 0){   
            mysqli_free_result($result);
            $password = mysqli_real_escape_string($connect, $_POST['password']);
            $sql = "SELECT name FROM  user WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($connect, $sql);
            $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
            //check password
            if(!empty($user)){   
               $status = 'Hello '. $user['name'];
               mysqli_free_result($result);
               mysqli_close($connect);
            }else{
               $errors['password'] = 'wrong password .';
            }
         }else{
            $errors['username'] = 'username doesn\'t exist .';
         }
      }
   ?>

   <body class="background">
      <form id="login_form" action="login.php" method="POST">      
         <p class="lead">login to your account</p> 
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-people"></i></div>
               <input type="text" name="username"  class="form-control" placeholder="Enter Your Username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>  
            <div class="text-danger"><?php echo $errors['username']?></div>
         </div>  
                  
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></div>
               <input type="password"  name="password" class="form-control" placeholder="Enter Your password"  value="<?php echo htmlspecialchars($password); ?>" required>
            </div>
            <div class="text-danger"><?php echo $errors['password']?></div>
         </div>

         <br>
         <button class="btn btn-outline-secondary" type="submit" name="login" value="login" >Login</button>
         <div class="text-warning  text-center"><?php echo $status?></div>
      </form>
   </body>
</html>
