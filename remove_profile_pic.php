<?php 
    include('connect.php');

    session_start();
    $id = $_SESSION['user_id'];

    $removeProfileQuery = "UPDATE users SET image_url='images/default_user.jpg' WHERE id = '$id' ";
    mysqli_query($db, $removeProfileQuery);
    $_SESSION['remove_profile'] = 1;

    header('location:profile.php');
?>