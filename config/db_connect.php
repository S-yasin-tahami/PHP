<?php
    $connect = mysqli_connect('localhost', 'admin', 'admin_password', 'film_criticism');
    if(!$connect){
        echo 'connection error : '. mysqli_connect_error();
    }
?>