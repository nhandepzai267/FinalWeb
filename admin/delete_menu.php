<?php
include 'connect_db.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $delete_query = "DELETE FROM menu_product WHERE id = $id";
    $delete_result = mysqli_query($con, $delete_query);
    
    if($delete_result) {
        echo "success";
    } else {
        echo "error";
    }
}
?>