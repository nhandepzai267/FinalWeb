<?php
include './connect_db.php';
if(!isset($_SESSION)) { 
    session_start(); 
}

$id = $_GET['id'];
$sql = "DELETE FROM orders WHERE id = $id";
$query = mysqli_query($con, $sql);

if($query) {
    echo 'success';
} else {
    echo 'error';
}
?>
