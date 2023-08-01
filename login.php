<?php
    include('connect.php');
    $login = 0;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $selectQuery = "SELECT * FROM users WHERE email='$email' ";
        $rawResult = mysqli_query($db, $selectQuery);
        $num = mysqli_num_rows($rawResult);

        if($num > 0) {
            $result = mysqli_fetch_assoc($rawResult);

            $hashedPassword = $result['password'];

            if(password_verify($password, $hashedPassword)) {
                $login = 2;

                session_start();
                $_SESSION['user_id'] = $result['id'];

                header('location:profile.php');
            }
            else {
                $login = 1;
            }

        }

        else {
            $login = 1;
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
            <h1>Login</h1>
            <hr>
            <div class="links">
                <a href="index.php">register</a>
                <a href="login.html" class="active">Login</a>
            </div>

            <?php 
                if($login === 1) {
                    echo
                        '<div class="alerts error">
                            <p>Incorrect username or password</p>
                            <div class="close-btn">X</div>
                        </div>';
                }
            ?>

            <form action="login.php" method="post">
                
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

                <input type="submit" value="Login">
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