<!DOCTYPE html>
<html>
  <head><title>Browse movies</title></head>
  <?php include 'Templates/header.php'; ?>
  <?php include 'config/db_connect.php';?>

  <?php
    $sql = "SELECT id, name, director, year,poster FROM movie";
    $result = mysqli_query($connect, $sql);
  ?>

  <body class="background">

    <?php while ($movie = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
      <div class="container movies justify-content-center">
        <div class="row">
          <div class="col-7">
            <div class="col">
              <img src="<?php echo $movie['poster']?>" alt="poster" height="500px" width="350px"> 
            </div>
            <div class=" m-3 p-3">
              <h5 class="text-secondary">name: </h5><p><?php echo $movie['name'] ?></p><br>
              <h5 class="text-secondary">year: </h5><p><?php echo $movie['year'] ?></p><br>
              <h5 class="text-secondary">director: </h5><p><?php echo $movie['director'] ?></p>
              <a href="add_comment.php?id=<?php echo $movie['id']?>" class="btn btn-secondary">Add comment</a> 
            </div> 
          </div>   
        </div>
      </div>
    <?php  } ?>
    <?php
      mysqli_free_result($result);
      mysqli_close($connect);
    ?>
  </body>
</html>