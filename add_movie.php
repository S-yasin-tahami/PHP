<!DOCTYPE html>
<html>
   <head><title>Add movie</title></head>
   <?php include 'Templates/header.php'; ?>
   <?php include 'config/db_connect.php';?>
   <?php
   
   $name = $director = $writer = $producer = $cast = $music_composer = $year = $genre = $poster = $synopsis = $status = '';
   $errors = array('name' => '', 'director' => '', 'writer' => '', 'producer' => '', 'cast' => '', 'music_composer' => '', 'year' => '', 'genre' => '', 'poster' => '');
   
   if(isset($_POST['Add_movie'])){

      //input validation
      $name = $_POST['name'];
      if(preg_match('/^[a-zA-Z0-9_\s]+$/', $name)){
         $errors['name'] = 'name can only contain letters, numbers  and underscores .';
      }
      $director = $_POST['director'];
      if(preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $director)){
         $errors['director'] = 'director should Separated by Comma .';
      }
      $writer = $_POST['writer'];
      if(!preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $writer)){
         $errors['writer'] = 'writer should Separated by Comma .';
      }
      $producer = $_POST['producer'];
      if(!preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $producer)){
        $errors['producer'] = 'producer should Separated by Comma .';
      }  
      $cast = $_POST['cast'];
      if(!preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $cast)){
         $errors['cast'] = 'cast should Separated by Comma .';
      }
      $music_composer = $_POST['music_composer'];
      if(!preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $music_composer)){
         $errors['music_composer'] = 'music composer should Separated by Comma .';
      }
      $genre = $_POST['genre'];
      if(!preg_match('/^[a-zA-Z\s]+(,\s?[a-zA-Z\s]*)*$/', $genre)){
         $errors['genre'] = 'genre should Separated by Comma .';
      }
      //poster validation
      $target_dir = "poster/";
      $target_file = $target_dir . basename($_FILES["poster"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // change images name to movie name
      $temp = explode(".", $_FILES["poster"]["name"]);
      $poster_name = $_POST['name'] . '.' . end($temp);
      $poster_url = $target_dir. $poster_name;
      $check = getimagesize($_FILES["poster"]["tmp_name"]);
      if($check == false) {
         $errors['poster'] = 'poster is not an image .';
      }
      if (file_exists($poster_url)) {
         $errors['poster'] = 'poster already exists .';
      }
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
         $errors['poster'] = 'only JPG, JPEG & PNG files are allowed .';
      }
      if (!empty($errors['poster'])) {
         $errors['poster'] = 'your poster was not uploaded .';
      } else {
         if ( !move_uploaded_file($_FILES["poster"]["tmp_name"], $target_dir . $poster_name)) {
            $errors['poster'] = 'there was an error uploading your poster .';
         }
      }
      // add to database
      if(!array_filter($errors)){
         $name = mysqli_real_escape_string($connect, $_POST['name']);
         $director = mysqli_real_escape_string($connect, $_POST['director']);
         $writer = mysqli_real_escape_string($connect, $_POST['writer']);
         $producer = mysqli_real_escape_string($connect, $_POST['producer']);
         $cast = mysqli_real_escape_string($connect, $_POST['cast']);
         $music_composer = mysqli_real_escape_string($connect, $_POST['music_composer']);
         $year = mysqli_real_escape_string($connect, $_POST['year']);
         $genre = mysqli_real_escape_string($connect, $_POST['genre']);
         $poster = mysqli_real_escape_string($connect, $poster_url);
         $synopsis = mysqli_real_escape_string($connect, $_POST['synopsis']);
         $sql = "INSERT INTO movie(name, director, writer, producer, cast, music_composer, year, genre, poster, synopsis) VALUE ('$name', '$director ', '$writer ', '$producer', '$cast', '$music_composer', '$year', '$genre', '$poster', '$synopsis')";
         if(mysqli_query($connect, $sql)){
            $status = 'done .';
         }else{
            $status = 'connection error '. mysqli_error($connect);
         }
      }
   }
   ?>

   <body class="background">
      <div class="container add_movie">
         <form action="add_movie.php" method="POST" enctype="multipart/form-data">
            <div class="row" >
               <div class="col-5">
                  <div class=" m-3 p-3">
                     <p class="lead">insert movie information</p>
                     <div class="form-group">
                        <br>
                        <div class="input-group">
                           <div class="input-group-text" id="basic-addon1"> name</div>
                           <input type="text"name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>                           
                        </div>
                        <div class="text-danger"><?php echo $errors['name'] ?></div> 
                     </div>
                     
                     <div class="form-group">
                        <br>
                        <div class="input-group">
                           <div class="input-group-text" id="basic-addon1">director</div>
                           <input type="text" name="director" class="form-control" value="<?php echo htmlspecialchars($director); ?>" required>
                        </div>
                        <div class="text-danger"><?php echo $errors['director'] ?></div> 
                     </div>
                     
                     <div class="form-group">
                        <br>
                        <div class="input-group">
                           <div class="input-group-text" id="basic-addon1">writer</div>
                           <input type="text" name="writer" class="form-control" value="<?php echo htmlspecialchars($writer); ?>" required>
                        </div>
                        <div class="text-danger"><?php echo $errors['writer'] ?></div> 
                     </div>
                  
                     <div class="form-group">
                        <br>
                        <div class="input-group">
                           <div class="input-group-text" id="basic-addon1">producer</div>
                           <input type="text" name="producer" class="form-control" value="<?php echo htmlspecialchars($producer); ?>" required>
                        </div>
                        <div class="text-danger"><?php echo $errors['producer'] ?></div>
                     </div>
                  
                     <div class="form-group"> 
                        <br>
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text">cast</span>
                           </div>
                           <textarea class="form-control" aria-label="cast" name="cast" cols="40" rows="1" value="<?php echo htmlspecialchars($cast); ?>" required></textarea>
                        </div>
                     </div>  
                     <div class="text-danger"><?php echo $errors['cast'] ?></div>

                     <br>
                     <button class="btn btn-outline-secondary" type="submit" name="Add_movie" value="ADD" >ADD</button>
                     <div class="text-warning "><?php echo $status?></div>
                  </div> 
               </div>  

               <div class="col-5">
                  <div class="mt-5 pt-4">
                     <div class="form-group">
                           <br>
                           <div class="input-group">
                              <div class="input-group-text" id="basic-addon1">music_composer</div>
                              <input type="text"name="music_composer" class="form-control" value="<?php echo htmlspecialchars($music_composer); ?>" required> 
                           </div>
                           <div class="text-danger"><?php echo $errors['music_composer'] ?></div>
                        </div>

                        <div class="form-group">
                           <br>
                           <div class="input-group">
                              <div class="input-group-text" id="basic-addon1">year</div>
                              <input type="number" name="year" min="1800" max="2100" step="1" value="<?php echo htmlspecialchars($year); ?>" required>  
                           </div>
                           <div class="text-danger"><?php echo $errors['year'] ?></div>
                        </div>

                        <div class="form-group">
                           <br>
                           <div class="input-group">
                              <div class="input-group-text" id="basic-addon1">genre</div>
                              <input type="text"name="genre" class="form-control" value="<?php echo htmlspecialchars($genre); ?>" required> 
                           </div>
                           <div class="text-danger"><?php echo $errors['genre'] ?></div>
                        </div>

                        <div class="form-group">
                           <br>
                           <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                 <input class="form-control" name="poster" type="file" id="poster" value="<?php echo htmlspecialchars($poster); ?>" required>
                              </div>
                              <div class="text-danger"><?php echo $errors['poster'] ?></div>
                           </div>
                        </div>

                        <div class="form-group"> 
                           <br>
                           <div class="input-group">
                              <div class="input-group-prepend">
                                 <span class="input-group-text">synopsis</span>
                              </div>
                              <textarea class="form-control" aria-label="synopsis" name="synopsis" cols="35" rows="1" value="<?php echo htmlspecialchars($synopsis); ?>" required></textarea>
                        </div>
                     </div>
                  </div> 
               </div>
            </div>
         </form>    
      </div> 
   </body>
</html>