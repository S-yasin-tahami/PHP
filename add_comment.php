<!DOCTYPE html>
<html>
    <head><title>add comment</title></head>
    <?php include 'Templates/header.php'; ?>
    <?php include 'config/db_connect.php';?>
    <?php
        $name = $mail = $message = '';
        $errors = array('message' => '', 'name' => '', 'email' => '', 'query' => '');

        if(isset($_GET['id'])){

            $id = mysqli_real_escape_string($connect, $_GET['id']); 
            $sql = "SELECT * FROM movie WHERE id = $id";
            $result = mysqli_query($connect, $sql);
            $movie = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_free_result($result);

            if(isset($_POST['submit'])){

                //check if name exist 
                $name = mysqli_real_escape_string($connect, $_POST['name']);
                $sql = "SELECT id FROM user WHERE (name = '$name')";
                $result = mysqli_query($connect, $sql);
                if (mysqli_num_rows($result) > 0){
                    mysqli_free_result($result);
                    $email = mysqli_real_escape_string($connect, $_POST['email']);
                    //check email entered correctly
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $sql = "SELECT name, email,id, comment_count FROM user WHERE (name = '$name' AND email = '$email' )";
                        $result = mysqli_query($connect, $sql);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $user_id =$user['id'];
                        $user_comment_count = $user['comment_count'];
                        mysqli_free_result($result);
                        if(!empty($user)){  
                            $message = mysqli_real_escape_string($connect, $_POST['message']);
                            $movie_id = $_GET['id'];
                            $sql = "SELECT name FROM movie WHERE (id = $movie_id)";
                            $result= mysqli_query($connect, $sql );
                            $movie_name = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            $movie_name = $movie_name['name'];
                            mysqli_free_result($result);
                            $sql = "INSERT INTO comment(movie_name, comment, user_id) VALUE ('$movie_name', '$message', '$user_id')";
                            if($result = mysqli_query($connect, $sql)){
                                $user_comment_count += 1;
                                $sql =" UPDATE user SET comment_count = '$user_comment_count' WHERE (id = '$user_id')";
                                if(mysqli_query($connect, $sql)){
                                    mysqli_free_result($result);
                                }else{
                                    $errors['query'] = 'query error : '. mysqli_error($connect);
                                }
                            }
                        }else{
                            $errors['email'] = 'email doesn\'t math .';
                        }
                    }else{
                        $errors['email'] = 'Email is not Valid <br>';
                    }
                }else{
                    $errors['name'] = 'name doesn\'t exist. ';
                }
            }
        }else{
            $movie = array('name' => '', 'director' => '', 'writer' => '', 'producer' => '', 'cast' => '', 'music_composer' => '', 'year' => '', 'genre' => '', 'synopsis' => '', 'poster' => '');
        }
    ?>

    <body class="background">
        <div class="container movie justify-content-center">
            <div class="row">
                <div class="col-7">
                    <div class=" m-3 p-3">
                        <h5 class="text-secondary" > name: </h5><p> <?php echo $movie['name']?> </p>
                        <h5 class="text-secondary" > director:  </h5><p><?php echo $movie['director']?> </p>
                        <h5 class="text-secondary" > writer:  </h5><p><?php echo $movie['writer']?> </p>
                        <h5 class="text-secondary" > producer:  </h5><p><?php echo $movie['producer']?> </p>
                        <h5 class="text-secondary" > cast:  </h5><p><?php echo $movie['cast']?> </p>
                        <h5 class="text-secondary" > music_composer:  </h5><p><?php echo $movie['music_composer']?> </p>
                        <h5 class="text-secondary" > year:  </h5><p><?php echo $movie['year']?> </p>
                        <h5 class="text-secondary" > genre:  </h5><p><?php echo $movie['genre']?> </p>
                        <h5 class="text-secondary" > synopsis:  </h5><p><?php echo $movie['synopsis']?> </p> <br>
                    </div> 
                </div>   
            <div class="col">
                <img src="<?php echo $movie['poster'] ?>" alt="poster"height="500px" width="350px"> 
            </div>
            </div> 
        </div> <br>
    
        <section>
            <div class="container">
                <div class="row">
                    <?php
                        $movie_name = $movie['name'];
                        $sql = "SELECT * FROM comment WHERE (movie_name = '$movie_name')";
                        $result = mysqli_query($connect, $sql);
                    ?>
                    <div class="col-sm-5 col-md-6 col-12 pb-4">
                        <h1 class="color">Comments</h1>
                        <?php  while ($comment = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                            <div class="mt-4 text-justify" id="comment">         
                                <?PHP  
                                    $Comment_user_id = $comment['user_id'];
                                    $comment_sql = "SELECT id,name FROM user WHERE (id = '$Comment_user_id')";
                                    $comment_result = mysqli_query($connect, $comment_sql);
                                    $user = mysqli_fetch_array($comment_result, MYSQLI_ASSOC);
                                    $user_id = $user['id'];
                                    $user_name = $user['name'];
                                    if($Comment_user_id == $user_id){  
                                ?>
                                <h4> <?PHP echo $user_name; ?> </h4>
                                <?php } ?>
                                <span><?php echo $comment['date']?></span>
                                <br>
                                <p><?php echo $comment['comment']?></p>
                            </div>
                        <?php } ?>
                        <?php
                        mysqli_free_result($result);
                        mysqli_close($connect);
                        ?>
                    </div>
                    
                    <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                        <form id="comment_form" action="add_comment.php?id=<?php echo $movie['id']?>" method="POST">
                            <div class="form-group">
                                <h4>Leave a comment</h4>
                                <label for="message">Message</label>
                                <textarea name="message" id=""msg cols="30" rows="5" class="form-control" style="background-color: black;" value="<?php echo htmlspecialchars($name); ?>" required></textarea>
                            </div>
                            <div class="text-danger"><?php echo $errors['message']  ?></div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" style="background-color: black;" required>
                            </div>
                            <div class="text-danger"><?php echo $errors['name']  ?></div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control "style="background-color: black;" required> 
                            </div>
                            <div class="text-danger"><?php echo $errors['email']  ?></div>

                            <div class="form-group"> <input id="post_button" class="btn" type="submit" name="submit" value="Post Comment"> </div>
                            
                            <div class="text-danger"><?php echo $errors['query']  ?></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>