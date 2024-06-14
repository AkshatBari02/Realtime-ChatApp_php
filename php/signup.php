<?php
    session_start();
    include_once "config.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = mysqli_real_escape_string($conn, $_POST['fname'] ?? '');
    $lname = mysqli_real_escape_string($conn, $_POST['lname'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');
        if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                // let's check that email already exist in the DataBase or not
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){ //if email already exist
                    echo "$email - This email already exist!";
                }else{
                    // let's check user upload file or not
                    if(isset($_FILES['image'])){ // if user upload file
                        $img_name = $_FILES['image']['name']; // getting user uploaded image name
                        $img_type = $_FILES['image']['type']; //getting user upload img type
                        $tmp_name = $_FILES['image']['tmp_name']; //this temporary name is used to save/move file in our folder

                        // let's explode image and get the last extension like jpg png
                        $img_explode = explode('.', $img_name);
                        $img_ext = end($img_explode); //here we get the extension of a user uploaded img file

                        $extensions = ['png', 'jpeg', 'jpg']; //here are some valid ext and we've stored them in array
                        if(in_array($img_ext,$extensions) === true){
                            $types = ["image/jpeg", "image/jpg", "image/png"];
                            if(in_array($img_type, $types) === true){
                                $time = time();
                                //this will return us the current time...
                                // we need this time coz when you uploading user img to in our folder we rename user file with current time so all the img file will have a unique name

                                // let's move he user uploaded img to our particular folder 
                                $new_img_name = $time.$img_name;

                                if(move_uploaded_file($tmp_name, "images/".$new_img_name)){
                                    $status = "Active now"; //once user signed up then his status will be Active now
                                    $random_id = rand(time(), 10000000); //creating random id for users

                                // let's inser all user data into table
                                    $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                    VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");

                                    if($sql2){
                                        $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                        if(mysqli_num_rows($sql3) > 0){
                                            $row = mysqli_fetch_assoc($sql3);
                                            $_SESSION['unique_id'] = $row['unique_id']; //using this session we need user unique_id in other php file
                                            echo "success";
                                        }else{
                                        echo "This email address not Exist";
                                        }
                                    }else{
                                        echo "Something went wrong. Try again!";
                                    }
                                }
                            }else{
                                echo "Please select a valid image file format (png, jpeg, jpg)";
                            }
                        }else{
                            echo "Please select an image file!";
                        }
                    }
                }        
            }else{
                echo "$email - This is not a valid email";
            }
        }else{
            echo "All input field are required!";
        }
    }else{
        echo "Ivalid Request Method!";
    }    
?>