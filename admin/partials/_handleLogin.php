<?php
session_start();
include '../../dbConnect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    
    $sql = "SELECT * FROM users WHERE username='$username'"; 
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    if ($num == 1){
        $row = mysqli_fetch_assoc($result);
        $userType = $row['userType'];
        
        if (password_verify($password, $row['password'])){ 
            // Login successful - Update lastLogin timestamp
            $userId = $row['id'];
            $updateSql = "UPDATE users SET lastLogin = CURRENT_TIMESTAMP WHERE id = '$userId'";
            $updateResult = mysqli_query($conn, $updateSql);
            
            // Set session variables and redirect
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $userId;
            
            if($userType == 1) {
                $_SESSION['adminloggedin'] = true;
                $_SESSION['adminusername'] = $username;
                $_SESSION['adminuserId'] = $userId;
                header("location: ../index.php");
            }
            else {
                header("location: ../index.php");
            }
            exit();
        } 
    }
    
    header("location: ../login.php?loginsuccess=false");
}
?>