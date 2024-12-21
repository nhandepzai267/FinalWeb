<?php
    include 'connect_db.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $delete = mysqli_query($con, "DELETE FROM `product` WHERE `id`='$id'");
        if($delete) {
            echo "<script>
                window.location.href = 'sanpham.php';
                localStorage.setItem('deleteSuccess', 'true');
            </script>";
        } else {
            echo "<script>
                alert('Xóa thất bại');
                window.location.href = 'sanpham.php';
            </script>";
        }
    }
?>