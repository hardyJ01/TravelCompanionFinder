<?php 
session_start();
$url="localhost";
$usr="root";
$pass="";
$dbs="project";
$port=3307;
$conn=new mysqli($url,$usr,$pass,$dbs,$port);

if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
$uid=$_SESSION["user_id"]??1;
$tripid=intval($_GET["id"]);

$sql="DELETE from trips where trip_id=? and user_id=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("ii",$tripid,$uid);

if($stmt->execute()){
    echo "success";
}
else{
    echo "error";
}
$conn->close();
?>