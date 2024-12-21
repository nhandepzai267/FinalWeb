<?php
include 'connect_db.php';

$category = mysqli_query($con, "SELECT * FROM `product`  ");
//B1: tính tổng số bản ghi

$total = mysqli_num_rows($category);

//B2 : THiết lập số bảng ghi trên 1 trang
$limit = 7;
//B3: tính số trang
$page = ceil($total / $limit);
//B4: lấy trang hiện tại
$current_page = (isset($_GET['page']) ? $_GET['page'] : 1);
//B5: tính start
$start = ($current_page - 1) * $limit;
//B6: query sử dụng limit
$category = mysqli_query($con,"SELECT * FROM `product` LIMIT $start,$limit");
    ?>
<!DOCTYPE html>
<html>

<head>
    <style>
       img{
  width: 100%;
}
.buttons{
    text-align: right;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 15px;
    line-height: 38px;
}
.buttons a{
    color: #FFF;
    padding: 10px;
    background: #f44336;
}
 .buttons a:hover {
    color: #ffffff;
    text-decoration: none;
    opacity: 0.8;
}
.page-item {
    border: 1px solid rgba(0,0,0,0.4);
    width: 35px;
    display: inline-block;
    text-align: center;
    line-height: 20px;
    color: black;
}

    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" type="../logo/png" sizes="32x32" href="../logo/logo.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    
</head>

<body class="theme-red">
    <!-- Page Loader -->
    
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar" style="background-color: #000000;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">ADMIN PAGE</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <?php
            include "info.php";
            ?>
            <!-- Menu -->
            <?php
            include "menu.php";
           ?>
            
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
       
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Quản lý</h2>
            </div>

            <!-- Widgets -->
            <?php
            include "quanly.php";
            ?>
            <!-- #END# Widgets -->
            
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quản lý sản phẩm
                            </h2>
                        </div>
                        <div class="body">
                        <div class="buttons">
                            <a href="./product_editing.php">Thêm sản phẩm</a>
                             </div>
                            <div class="table-responsive">
                            
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá cũ </th>
                                            <th>Giá mới </th>
                                            <!-- <th>Ngày cập nhật</th>
                                            <th>Ngày tạo</th>
                                            <th>Copy</th> -->
                                            <th>Sửa</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    date_default_timezone_set('Asia/Saigon');
                                    while ($row = mysqli_fetch_array($category)) { 
                                    ?>
                                
                                        <tr> 
                                            <td><img src="../<?= $row['image'] ?>" /></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= number_format ($row['price']) ?> đ</td>
                                            <td><?= number_format ($row['price_new']) ?> đ</td>
                                            <!-- <td><?= date('d/m/Y H:i', $row['last_updated']) ?></td>
                                            <td><?= date('d/m/Y H:i', $row['created_time']) ?></td>
                                            <td><a href="./product_editing.php?id=<?= $row['id'] ?>&task=copy" class="btn btn-danger">Copy</a></td> -->
                                            <td><a href="./product_editing.php?id=<?= $row['id'] ?>" class="btn btn-danger">Sửa</a></td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete-btn" data-id="<?= $row['id'] ?>">Xóa</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                     
                                </table>
                                <div class="pagination-bar my-3">
                                <div class="col-12">
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                        
                                        <ul class="pagination">
                                           
                                        <?php if($current_page -1 > 0) { ?>
                                            <li><a href="sanpham.php?page=<?php echo $current_page -1 ?>">&laquo;</a></li>
                                            <?php } ?>
                                            <?php for($i=1; $i<=$page ;$i++) { ?>
                                                <li class="<?php echo ($current_page ==$i) ? 'active' : '' ?>"><a href="sanpham.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                              <?php  }?>
                                              
                                              <?php if($current_page +1 <= $page ) { ?>
                                            <li><a href="sanpham.php?page=<?php echo $current_page +1 ?>">&raquo;</a></li>
                                            <?php } ?>
                                        </ul>
                                        
                                        
                                        </ul>
                                    </nav>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
            
        </div>
        <?php


?>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="plugins/flot-charts/jquery.flot.js"></script>
    <script src="plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="js/demo.js"></script>

    <!-- Thêm SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    .swal2-popup {
        font-size: 1.2em !important;
    }
    /* body.swal2-shown > [aria-hidden="true"] {
        transition: 0.1s filter;
        filter: blur(1px);
    } */
    body.swal2-shown {
        padding-right: 0 !important;
        overflow-y: auto !important;
    }
    .swal2-container {
        padding-right: 0 !important;
    }
</style>
    
    <!-- Script xử lý xóa -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lắng nghe sự kiện click trên các nút xóa
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    
                    Swal.fire({
                        title: 'Bạn có muốn xóa sản phẩm này?',
                        text: "Bạn sẽ không thể hoàn tác sau khi xóa!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'product_delete.php?id=' + id;
                        }
                    });
                });
            });

            // Kiểm tra và hiển thị thông báo sau khi xóa thành công
            if(localStorage.getItem('deleteSuccess')) {
                Swal.fire(
                    'Đã xóa!',
                    'Sản phẩm đã được xóa thành công.',
                    'success'
                );
                localStorage.removeItem('deleteSuccess');
            }
        });
    </script>
</body>

</html>
