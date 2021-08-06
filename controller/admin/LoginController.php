<?php
    include "../../config/db_config.php"; //include the database configuration file to connect with database
    session_start(); // start session to store variable data in session

    if(isset($_POST['submit'])){
        if(empty($_POST['email']) || empty($_POST['password'])){
            echo "<h4>Invalid Input</h4>";
        }
        else{
            $email      = $_POST['email'];
            $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql        = "SELECT * FROM users where email='$email' and password = '$password'";
            $db         = dbConnection();

            $alluser = mysqli_query($db, $sql); // EXECUTE QUERY

            while( $row = mysqli_fetch_assoc($alluser) ){
                $user           = array(
                    'id'    => $row['id'],
                    'name'  => $row['name'],
                    'email'  => $row['email'],
                    'phone'  => $row['phone'],
                    'address'  => $row['address'],
                    'image'  => $row['image'],
                    'user_type'  => $row['user_type'],
                );

                echo var_dump($usesr);

                if(($email == $user->email) && ($password == $row['password'])){
                    if($role == 'ADM'){
                        $_SESSION['user'] = $user;
                        setcookie('email', $email, time() + (86400 * 30), "/"); //SET EMAIL ADDRESS IN COOKIE FOR 30 DAYS
                        setcookie('password', $password, time() + (86400 * 30), "/"); //SET PASSWORD IN COOKIE FOR 30 DAYS
                        header('location: ../../views/admin/dashboard.php');
                        echo "true";
                        break;
                    }
                }
            } 
            
            if(mysqli_num_rows($alluser) == 0){
                $_SESSION['loginError'] = 'Invalid Information...';
                header('location: ../../views/login.php');
            }
        }
    }
    else{

    }
?>