<?php
session_start();
include '../includes/db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql="SELECT * FROM users WHERE email='$email'";
$stmt=$conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();;
$result=$stmt->get_result();

if($result->num_rows >0){
    $user=$result->fetch_assoc();
    if(password_verify($password, $user['password'])){
        $_SESSION['user_id']=$user['id'];
        $_SESSION['email']=$user['email'];
        header("Location: ../dashboard.php");
    } else {
        echo "Invalid password.";
    }
}
else {
    echo "No user found with that email.";
}