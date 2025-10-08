<?php
session_start();
include '../includes/db_connect.php';

// get form values
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$created_at = date('Y-m-d H:i:s');

// insert user into database
$stmt = $conn->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $created_at);
if ($stmt->execute()) {
    $_SESSION['signup_success'] = "Signup successfull! Please login with your credentials.";
    header("Location: ../src/signup.php");
    exit();
} else {
    $_SESSION['signup_error'] = "Email already registered. Please use a different email.";
    header("Location: ../src/signup.php");
    exit();
}