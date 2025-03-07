<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $username = $_POST["loginUsername"];
    $password = $_POST["loginPassword"]; 
    
    $sql = "SELECT * FROM users WHERE username='$username'"; 
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        $row=mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){ 
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $row['id'];
            header("location: ../index.php?loginsuccess=true");
            exit();
        } 
    }
    header("location: ../index.php?loginsuccess=false");
}
?>