<?php 
    include('connect.php');
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];
        $file = $_FILES['image'];

        $error = $file['error'];

        if($error === 4) {
            $_SESSION['update_profile'] = 2;
        }

        else{
            $selectUserQuery = "SELECT * FROM users where id = $id";
            $rawUser = mysqli_query($db, $selectUserQuery);
            $user = mysqli_fetch_assoc($rawUser);
            
            $validFileExtensions = array('jpg', 'jpeg', 'png');

            $imageName = $file['name'];
            $temp_name = $file['tmp_name'];
            
            $fileExtension = explode('.', $imageName);
            $fileExtension = strtolower(end($fileExtension));

            if(!in_array($fileExtension, $validFileExtensions)) {
                $_SESSION['update_profile'] = 3;
            }
            
            else {
                $newFileName = explode('@', $user['email'])[0] . '.' . $fileExtension;
                $filePath = 'images/'.$newFileName;

                move_uploaded_file($temp_name, $filePath);

                $updateProfileQuery = "UPDATE users SET image_url='$filePath' WHERE id = $id ";
                mysqli_query($db, $updateProfileQuery);

                $_SESSION['update_profile'] = 1;
            }

        }
        header('location:profile.php');
    }
?>