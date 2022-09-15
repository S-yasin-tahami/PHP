<!DOCTYPE html>
<html>
   <head><title>signup</title></head>
   <?php include 'Templates/header.php'; ?>
   <?php include 'config/db_connect.php';?>

<?php

   $name = $email = $username = $password = $confirm_password = $status = '' ;
   $errors = array('name' => '', 'email' => '', 'username' => '', 'confirm_password' => '');

   if(isset($_POST['submit'])){
      
      // input validation
      $name = $_POST['name'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $name )){
			$errors['name'] = 'name must be letters and spaces only .';
		}
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
         $errors['email'] = 'Email is not Valid .';
      }   
      $username = $_POST['username'];
      if(!preg_match('/^[a-zA-Z0-9_]+$/',$username )){
         $errors['username'] = 'Username can only contain letters, numbers  and underscores .';
      }else{
         $sql = "SELECT * FROM user WHERE (username = '$username')";
         $result = mysqli_query($connect, $sql);
         if(mysqli_num_rows($result) > 0){
            $errors['username'] = 'username already exist .';
         }
      }
      if($_POST['password'] != $_POST['confirm_password']){
         $errors['confirm_password'] = 'password doesn\'t math ';
      }
      //add to database
      if(!array_filter($errors)){
         $name = mysqli_real_escape_string($connect, $_POST['name']);
         $email = mysqli_real_escape_string($connect, $_POST['email']);
         $username = mysqli_real_escape_string($connect, $_POST['username']);
         $password = mysqli_real_escape_string($connect, $_POST['password']);
         $sql = "INSERT INTO user(name, email, username, password) VALUES ('$name', '$email', '$username', '$password')";
         if(mysqli_query($connect, $sql)){
            $status = 'yor account registered .';
         }else{
            $status = 'Query Error : '. mysqli_error($connect);
         }
      }
   }
?>

   <body class="background">
      <form id="signup_form" action="signup.php" method="POST">
         <p class="lead">Sign up for unlimited access</p>

         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></div>
               <input type="text" name="name" class="form-control" placeholder="Enter Your Name" value="<?php echo htmlspecialchars($name); ?>" required> 
            </div>
            <div class="text-danger"><?php echo $errors['name'] ?></div> 
         </div>
         
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></div>
               <input type="text" name="email" class="form-control" placeholder="Enter Your Email"  value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="text-danger"><?php echo $errors['email'] ?></div> 
         </div>
         
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-people"></i></div>
               <input type="text" name="username"  class="form-control" placeholder="Enter Your Username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="text-danger"><?php echo $errors['username'] ?></div> 
         </div>
      
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></div>
               <input type="password"  name="password" class="form-control" placeholder="Enter Your password" value="<?php echo htmlspecialchars($password); ?>" required>
            </div>
         </div>
      
         <div class="form-group">
            <br>
            <div class="input-group">
               <div class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill"></i></div>
               <input type="password" name="confirm_password"  class="form-control" placeholder="confirm Your password" value="<?php echo htmlspecialchars($confirm_password); ?>" required>
            </div>
            <div class="text-danger"><?php echo $errors['confirm_password'] ?></div> 

         </div>
         <button class="btn btn-outline-secondary" type="submit" name="signup" value="Register" >Register</button>
         <div class="text-warning  text-center"><?php echo $status?></div>
      </form>   
   </body>
</html>
