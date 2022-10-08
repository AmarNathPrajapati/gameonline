<?php
    date_default_timezone_set('Asia/Kolkata');
     $servername = "localhost";
    //  $username = "syvyjuld_user_prod1";
    //  $password = "FeU7z{x{d!p!";
    //  $database = "syvyjuld_web_gleam_db";
     $username = "root";
     $password = "";
     $database = "web_gleam_db";
   
    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);
   
    // Die if connection was not successful
   
    if (!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }
?>