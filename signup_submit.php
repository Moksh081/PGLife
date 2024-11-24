<?php
    // $db_hostname = "127.0.0.1";
    // $db_username = "root";
    // $db_password = "";
    // $db_name = "pglife";
    
    // $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
    // if (!$conn) {
    //     echo "Connection failed: " . mysqli_connect_error();
    //     exit;
    // }

    include "includes/database_connect.php";
    $full_name=$_POST['full_name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password= sha1($password);
    $phone=$_POST['phone'];
    $gender=$_POST['gender'];
    $college_name=$_POST['college_name'];

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
        echo "Something went wrong";
        exit;
    }

    $row_count = mysqli_num_rows($result);
    if($row_count !=0){
        echo "This email id is already registered with us!";
        exit;
    }

    $sql = "INSERT INTO users(email , PASSWORD , full_name , phone , gender , college_name) VALUES ('$email', '$password', '$full_name', '$phone','$gender','$college_name')";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    echo "Registration successful";
    
    ?>
    <br/>
    <a href="index.php">GO TO HOMEPAGE</a>
    <?php
    mysqli_close($conn);
?>