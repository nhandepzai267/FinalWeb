<?php
include './connect_db.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']); // Bảo vệ khỏi SQL injection
    $result = mysqli_query($con, "DELETE FROM `user` WHERE `id` = '$id'");
    
    if ($result) {
        mysqli_close($con);
        header('Location: khachhang.php?delete=success');
        exit();
    } else {
        $error = mysqli_error($con);
        mysqli_close($con);
        header('Location: khachhang.php?delete=error&message=' . urlencode($error));
        exit();
    }
} else {
    header('Location: khachhang.php');
    exit();
}
?>
