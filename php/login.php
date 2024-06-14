<?php
    session_start();
    include_once "config.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
        $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');
        
        if(!empty($email) && !empty($password)){
            // let's check user enterd email & password matched to database an table row email and password
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
            if(mysqli_num_rows($sql) > 0){ //if users credentials matched
                $row = mysqli_fetch_assoc($sql);
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if($sql2){
                    $_SESSION['unique_id'] = $row['unique_id']; //using this session we need user unique_id in other php file
                    echo "success";
                }
               
            }else{
                echo "Email or Password is incorrect";
            }
        }else{
            echo "All input fields are required!";
        }

    }else{
        echo "Ivalid Request Method!";
    }   
?>