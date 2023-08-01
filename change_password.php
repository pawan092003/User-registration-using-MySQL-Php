<?php 
    include('connect.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $oldPassword = $_POST['old_password'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        session_start();
        $id = $_SESSION['user_id'];
        $_SESSION['changePassword'] = 0;

        $oldPasswordQuery = "SELECT * FROM users WHERE id='$id' ";
        $passwordResult = mysqli_query($db, $oldPasswordQuery);

        if(mysqli_num_rows($passwordResult) > 0) {
            $pResult = mysqli_fetch_assoc($passwordResult);

            $oldPasswordHash = $pResult['password'];
            if(password_verify( $oldPassword, $oldPasswordHash)) {
                if($password1 === $password2) {
                    $newPasswordHash = password_hash($password1, PASSWORD_BCRYPT);
                    $updatePasswordQuery = "UPDATE users SET PASSWORD = '$newPasswordHash' WHERE id = '$id' ";
                    mysqli_query($db, $updatePasswordQuery);
                }
                else {
                    $_SESSION['changePassword'] = 2;
                }
            }
            else {
                $_SESSION['changePassword'] = 1;
            }
        }


        header('location:profile.php');
    }
?>
