<?php
    include('connect.php');
    // include('change_password.php');
    session_start();

    if(!isset($_SESSION['user_id'])) {
        header('location:login.php');
    }
    else {
        $id = $_SESSION['user_id'];

        $selectQuery = "SELECT * FROM users WHERE id='$id'" ;
        $rawUser = mysqli_query($db, $selectQuery);
        $user = mysqli_fetch_assoc($rawUser);

        $name = $user['username'];
        $email = $user['email'];
        $image_url = $user['image_url'];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>

        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="profile-card">
            <div class="profile-pic">
                <img 
                    src=<?php echo "$image_url" ?> 
                    alt="image"
                />
            </div>
            <div class="profile-info">
                <h3>
                    <?php echo "$name"; ?>
                </h3>
                
                <h4>
                    <?php echo "$email"; ?>
                </h4>

                <?php 
                    if(isset($_SESSION['changePassword'])) {
                        $cp = $_SESSION['changePassword'];

                        if($cp === 0) {
                            echo
                                '<div class="alerts full success">
                                    <p>Password Updated Successfully</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }
                        
                        elseif($cp === 1) {
                            echo
                                '<div class="alerts full error">
                                    <p>Old Password don\'t match</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }
                        
                        elseif($cp === 2) {
                            echo
                                '<div class="alerts full error">
                                    <p>Conform Password don\'t match</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }

                        else {
                            echo '';
                        }

                        $_SESSION['changePassword'] = 3;
                    }

                    if(isset($_SESSION['remove_profile'])) {
                        if($_SESSION['remove_profile'] === 1) {
                            echo
                                '<div class="alerts full success">
                                    <p>Profile pic removed Successfully</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }

                        $_SESSION['remove_profile'] = 0;
                    }

                    if(isset($_SESSION['update_profile'])) {
                        if($_SESSION['update_profile'] === 1) {
                            echo
                                '<div class="alerts full success">
                                    <p>Profile pic updated Successfully</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }

                        elseif($_SESSION['update_profile'] === 2) {
                            echo
                                '<div class="alerts full error">
                                    <p>Please select a file</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }

                        elseif($_SESSION['update_profile'] === 3) {
                            echo
                                '<div class="alerts full error">
                                    <p>Invalid file format for image</p>
                                    <div class="close-btn">X</div>
                                </div>';
                        }

                        $_SESSION['update_profile'] = 0;
                    }
                ?>

                <div class="btn-box">
                    <p class="title">Edit profile pic</p>
                    <button type="button" class="btn remove"><a href="remove_profile_pic.php">Remove</a></button>
                    
                    <form  id="form" action="update_profile_pic.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" id="image">
                        
                        <label for="image">
                            <div class="btn update">Update</div>
                        </label>

                    </form>
                </div>

                <button type="button" class="btn change-password">Change Password</button>
                <button type=" button" class="btn"><a href="logout.php">Logout</a></button>
            </div>
        </div>  
        
        <div class="popup">  
        </div>

        <div class="popup-content">
            <div class="popup-header">
                <h1>Change Password</h1>
                <button id="close-popup">&times;</button>
            </div>
            <hr>
            <form action="change_password.php" method="post">
                <input type="password" name="old_password" placeholder="Enter your old password"> <br>
                <input type="password" name="password1" placeholder="Enter your new password"> <br>
                <input type="password" name="password2" placeholder="Reenter password"><br>
                <input type="submit" value="Submit">
            </form>
        </div>

        <script>
            const form = document.querySelector("#form");
            const popup = document.querySelector('.popup');
            const fileInput = document.querySelector("#image");
            const alerts = document.querySelectorAll('.alerts');
            const btn = document.querySelector('.change-password');
            const closeBtn = document.querySelector('#close-popup');
            const popupContent = document.querySelector('.popup-content');
            
            fileInput.onchange = () => {
                form.submit();
            }

            btn.addEventListener('click', () => {
                popup.style.display = 'block';
                popupContent.classList.add('show');
            });
            
            closeBtn.onclick = () => {
                popupContent.classList.remove('show');
                popup.style.display = 'none';
            }
            

            alerts.forEach(alert => {
                alert.addEventListener('click', () => {
                    alert.parentNode.removeChild(alert);
                })
            })

        </script>


    </body>
</html>