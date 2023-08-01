<?php 
    include('connect.php');
    $signup = 0;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'];
        $name = $_POST['username'];
        $image = $_FILES['image'];
        $email = $_POST['email'];

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $searchQuery = "SELECT * FROM users WHERE email='$email' ";
        
        $result = mysqli_query($db, $searchQuery);
        
        if(mysqli_num_rows($result) > 0) {
            $signup = 1;
        }
        else {
            $error = $image['error'];
            if($error === 4) {
                $insertQuery = "INSERT INTO users(username, password, email) VALUES('$name', '$hashedPassword', '$email')";
                mysqli_query($db, $insertQuery);
                $signup = 2;
            }

            else {
                $validFileExtensions = array('jpg', 'jpeg', 'png');
                $temp_name = $image['tmp_name'];
                $imageName = $image['name'];
                
                $imageExtension = explode('.', $imageName);
                $imageExtension = strtolower(end($imageExtension));

                if(!in_array($imageExtension, $validFileExtensions)) {
                    $signup = 3;
                }

                else {
                    $newFileName = explode('@', $email)[0].'.'.$imageExtension;
                    $filePath = 'images/'.$newFileName;

                    move_uploaded_file($temp_name, $filePath);

                    $insertQuery = "INSERT INTO users(username, password, email, image_url) VALUES('$name', '$hashedPassword', '$email', '$filePath')";
                    mysqli_query($db, $insertQuery);
                    $signup = 2;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>

        <link rel="stylesheet" href="style.css">

        <link rel="stylesheet" 
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
            crossorigin="anonymous" 
            referrerpolicy="no-referrer" />
    </head>
    
    <body>
        <div class="form-section">
            <h1>Register</h1>
            <hr>
            <div class="links">
                <a href="index.php" class="active">register</a>
                <a href="login.php">Login</a>
            </div>

            <?php 
                if($signup === 1) {
                    echo
                        '<div class="alerts error">
                            <p>Email is already registered</p>
                            <div class="close-btn">X</div>
                        </div>';
                }

                elseif($signup === 2) {
                    echo
                        '<div class="alerts success">
                            <p>Account created successfully</p>
                            <div class="close-btn">X</div>
                        </div>';
                }
                
                elseif($signup === 3) {
                    echo
                        '<div class="alerts error">
                            <p>Invalid file format for image</p>
                            <div class="close-btn">X</div>
                        </div>';
                }
            ?>
            
            <form action="index.php" method="post" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="username" placeholder="Enter your username">
                </div>
                
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>
               
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" placeholder="Enter your password">
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <label for="file-id"><i class="fa-solid fa-upload"></i></label>
                    </div>
                    <input type="file" id="file-id" name="image">
                </div>

                <input type="submit" value="signup">
            </form>

        </div>

        <script>
            const alerts = document.querySelectorAll('.alerts');

            alerts.forEach(alert => {
                alert.addEventListener('click', () => {
                    alert.parentNode.removeChild(alert);
                })
            })

        </script>
    </body>
</html>